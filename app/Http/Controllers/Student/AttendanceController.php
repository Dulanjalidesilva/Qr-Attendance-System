<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class AttendanceController extends Controller
{
    // 📱 QR Scan
public function scan($lecture_id)
{
    $lecture = Lecture::findOrFail($lecture_id);

    // ✅ Lecture expired?
    if (Carbon::parse($lecture->end_time)->isPast()) {
        return redirect()
            ->route('student.login')
            ->withErrors(['error' => 'QR expired. Lecture has ended.']);
    }

    // ✅ Device ID (cookie)
    $deviceId = request()->cookie('device_id');
    if (!$deviceId) {
        $deviceId = (string) Str::uuid();
        Cookie::queue('device_id', $deviceId, 60 * 24 * 365);
    }

    // ❌ Block if THIS device already used for THIS lecture
    $deviceUsed = Attendance::where('lecture_id', $lecture_id)
        ->where('device_id', $deviceId)
        ->whereNotNull('scanned_at')
        ->exists();

    if ($deviceUsed) {
        return redirect()
            ->route('student.login')
            ->withErrors(['error' => 'This device has already scanned this lecture QR.']);
    }

    // Login check
    if (!auth()->check()) {
        session(['qr_lecture_id' => $lecture_id]);
        return redirect()->route('student.login');
    }

    $user = auth()->user();
    if (!$user->student) {
        auth()->logout();
        return redirect()->route('student.login');
    }

    $studentId = $user->student->id;
    $subjectId = $lecture->subject_id;

    // Enrolment check
    $isEnrolled = Subject::findOrFail($subjectId)
        ->students()
        ->where('students.id', $studentId)
        ->exists();

    if (!$isEnrolled) {
        return redirect()->route('student.dashboard')
            ->withErrors(['error' => 'You are not enrolled for this subject.']);
    }

    // ✅ SAFE: student duplicate handled, device duplicate blocked
    Attendance::updateOrCreate(
        [
            'lecture_id' => $lecture_id,
            'student_id' => $studentId,
        ],
        [
            'device_id'  => $deviceId,
            'status'     => 'present',
            'scanned_at' => now(),
        ]
    );

    return redirect()
        ->route('student.attendance.subject', $subjectId)
        ->with('success', 'Attendance marked successfully');
}


    // 📊 Attendance Report
    public function view($subject_id)
    {
        $user = auth()->user();

        if (!$user || !$user->student) {
            return redirect()->route('student.login');
        }

        $studentId = $user->student->id;

        $subject  = Subject::findOrFail($subject_id);
        $lectures = Lecture::where('subject_id', $subject_id)->get();

        $attendance = Attendance::where('student_id', $studentId)
            ->whereIn('lecture_id', $lectures->pluck('id'))
            ->get()
            ->keyBy('lecture_id');

        return view('student.attendance-report', compact(
            'subject',
            'lectures',
            'attendance'
        ));
    }
}
