<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LectureController extends Controller
{
    // 📋 List lectures
    public function index()
    {
        $lecturer = auth()->user()->lecturer;

        $lectures = Lecture::where('lecturer_id', $lecturer->id)
            ->with('subject')
            ->orderByDesc('start_time')
            ->get();

        return view('lecturer.lectures.index', compact('lectures'));
    }

    // ➕ Create lecture form
    public function create()
    {
        $subjects = Subject::all();
        return view('lecturer.lectures.create', compact('subjects'));
    }

    // 💾 Store lecture + init attendance
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        $lecturer = auth()->user()->lecturer;

        // Create lecture
        $lecture = Lecture::create([
            'subject_id'  => $request->subject_id,
            'lecturer_id' => $lecturer->id,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'qr_token'    => Str::random(40),
        ]);

        // ✅ Create ABSENT only if not exists
        $students = Student::whereHas('subjects', function ($q) use ($lecture) {
            $q->where('subjects.id', $lecture->subject_id);
        })->get();

        foreach ($students as $student) {
            Attendance::firstOrCreate(
                [
                    'lecture_id' => $lecture->id,
                    'student_id' => $student->id,
                ],
                [
                    'status'     => 'absent',
                    'scanned_at' => null,
                ]
            );
        }

        return redirect()
            ->route('lecturer.lectures.show', $lecture->id)
            ->with('success', 'Lecture created successfully.');
    }

    // 📱 Show QR code
    public function show($id)
    {
        $lecture = Lecture::with('subject', 'lecturer.user')->findOrFail($id);

        $qrUrl = route('student.scan', $lecture->id);

        return view('lecturer.lectures.show', compact('lecture', 'qrUrl'));
    }

    // 🗑️ DELETE lecture  ✅ NEW FEATURE
    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);

        // Security: only owner lecturer can delete
        if ($lecture->lecturer_id !== auth()->user()->lecturer->id) {
            abort(403, 'Unauthorized action');
        }

        // Attendance auto-deleted via cascade
        $lecture->delete();

        return redirect()
            ->route('lecturer.lectures.index')
            ->with('success', 'Lecture deleted successfully.');
    }
}
