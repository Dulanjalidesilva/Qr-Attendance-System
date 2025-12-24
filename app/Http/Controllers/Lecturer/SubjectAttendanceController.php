<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Lecture;
use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SubjectAttendanceController extends Controller
{
    /**
     * Display attendance table for a subject (web page)
     */
    public function view($id)
    {
        $subject = Subject::with('students.user')->findOrFail($id);

        $lectures = Lecture::where('subject_id', $id)
            ->orderBy('start_time')
            ->get();

        $attendance = Attendance::whereIn('lecture_id', $lectures->pluck('id'))
            ->whereNotNull('scanned_at')
            ->where('status', 'present')
            ->get()
            ->keyBy(fn ($a) => $a->student_id . '-' . $a->lecture_id);

        return view('lecturer.subjects.attendance', compact('subject', 'lectures', 'attendance'));
    }

    /**
     * Export attendance as PDF for lectures that have ended (SUBJECT-WISE)
     */
  public function exportPdf($id)
{
    $subject = Subject::with('students.user')->findOrFail($id);

    $lectures = Lecture::where('subject_id', $id)
        ->where('end_time', '<=', Carbon::now())
        ->orderBy('start_time')
        ->get();

    if ($lectures->isEmpty()) {
        return back()->with('error', 'No completed lectures yet.');
    }

    $attendance = Attendance::whereIn('lecture_id', $lectures->pluck('id'))
        ->whereNotNull('scanned_at')
        ->where('status', 'present')
        ->get()
        ->keyBy(fn ($a) => $a->student_id . '-' . $a->lecture_id);

    // ✅ FIXED view name (match: resources/views/lecturer/subjects/pdf.blade.php)
    $pdf = Pdf::loadView(
        'lecturer.subjects.pdf',
        compact('subject', 'lectures', 'attendance')
    )->setPaper('a4', 'landscape');

    return $pdf->download($subject->code . '_attendance.pdf');
}


    /**
     * ✅ NEW: Export attendance PDF for a SINGLE LECTURE (LECTURE-WISE)
     */
    public function exportLecturePdf($id)
    {
        $lecture = Lecture::with('subject.students.user')->findOrFail($id);

        // ✅ Lecture ended check
        if (Carbon::parse($lecture->end_time)->isFuture()) {
            return back()->with('error', 'Lecture has not ended yet.');
        }

        $students = $lecture->subject->students;

        // ✅ Only scanned attendance for THIS lecture
        $attendance = Attendance::where('lecture_id', $lecture->id)
            ->whereNotNull('scanned_at')
            ->where('status', 'present')
            ->get()
            ->keyBy('student_id');

        $pdf = Pdf::loadView(
            'lecturer.lectures.lecture-pdf',
            compact('lecture', 'students', 'attendance')
        )->setPaper('a4', 'portrait');

        return $pdf->download(
            $lecture->subject->code . '_lecture_' . $lecture->id . '_attendance.pdf'
        );
    }
}
