<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
{
    $student = auth()->user()->student;

    // load only subjects that lecturer assigned using pivot table
    $subjects = $student->subjects()->get();

    return view('student.dashboard', compact('subjects'));
}

}
