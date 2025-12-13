<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Lecture;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('admin.attendance.index');
    }

    public function search(Request $request)
    {
        $request->validate(['keyword' => 'required']);

        $student = Student::where('student_number', $request->keyword)
            ->orWhereHas('user', fn($q) => $q->where('email', $request->keyword))
            ->first();

        if (!$student) {
            return back()->with('error', 'No student found.');
        }

        $subjects = $student->subjects()->get();
        $lectures = Lecture::whereIn('subject_id', $subjects->pluck('id'))->get();
        $attendance = Attendance::where('student_id', $student->id)->get();

        return view('admin.attendance.result',
            compact('student', 'subjects', 'lectures', 'attendance'));
    }
}
