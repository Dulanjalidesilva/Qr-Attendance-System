<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Lecture;
use App\Models\Attendance;

class SubjectAttendanceController extends Controller
{
    public function view($id)
    {
        // Load subject with students
        $subject = Subject::with('students')->findOrFail($id);

        // Load all lectures under this subject
        $lectures = Lecture::where('subject_id', $id)->orderBy('start_time')->get();

        // Load attendance records
        $attendance = Attendance::whereIn('lecture_id', $lectures->pluck('id'))->get();

        return view('lecturer.subjects.attendance', compact('subject', 'lectures', 'attendance'));
    }
}
