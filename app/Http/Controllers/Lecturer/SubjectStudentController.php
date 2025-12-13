<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectStudentController extends Controller
{
    // Show student assignment page
    public function addStudents($id)
    {
        $subject = Subject::findOrFail($id);
        $students = Student::all(); // you may filter by batch later

        return view('lecturer.subjects.add-students', compact('subject', 'students'));
    }

    // Save students to subject
    public function storeStudents(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array',
        ]);

        $subject = Subject::findOrFail($id);

        // attach without removing existing ones
        $subject->students()->syncWithoutDetaching($request->student_ids);

        return redirect()->route('lecturer.dashboard')
            ->with('success', 'Students added successfully!');
    }

    public function viewStudents($id)
    {
        $subject = Subject::with('students')->findOrFail($id);

        return view('lecturer.subjects.view-students', compact('subject'));
    }

}
