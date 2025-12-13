<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'email'           => 'required|email|unique:users',
            'student_number'  => 'required|unique:students',
        ]);

        // 1. Create User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->student_number),  // password = student number
            'role'     => 'student',
        ]);

        // 2. Create Student record
        Student::create([
            'user_id'        => $user->id,
            'student_number' => $request->student_number,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student added successfully!');
    }
}
