<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        $students = Student::count();
        $lecturers = Lecturer::count();
        $subjects = Subject::count();

        return view('admin.dashboard', compact('students', 'lecturers', 'subjects'));
    }
}
