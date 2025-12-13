<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\Subject;

class AttendanceController extends Controller
{
    // 📱 QR Scan
    public function scan($lecture_id)
    {
        $lecture = Lecture::findOrFail($lecture_id);

        if (!auth()->check()) {
            session(['qr_lecture_id' => $lecture_id]);
            return redirect()->route('student.login');
        }

        // ✅ IMPORTANT: get STUDENTS table id (NOT users.id)
        $studentId = auth()->user()->student->id;

        Attendance::updateOrCreate(
            [
                'lecture_id' => $lecture_id,
                'student_id' => $studentId,
            ],
            [
                'status'     => 'present',
                'scanned_at' => now(),
            ]
        );

        return redirect()
            ->route('student.attendance.subject', $lecture->subject_id)
            ->with('success', 'Attendance marked successfully');
    }

    // 📊 Attendance Report
    public function view($subject_id)
    {
        $studentId = auth()->user()->student->id;

        $subject = Subject::findOrFail($subject_id);
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
