<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        $lecturer = auth()->user()->lecturer;

        // Get all subjects assigned to this lecturer
        $subjects = Subject::where('lecturer_id', $lecturer->id)->get();

        return view('lecturer.dashboard', compact('subjects'));
    }
}
