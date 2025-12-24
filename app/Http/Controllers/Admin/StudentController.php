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
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'student_number' => 'required|string|max:50|unique:students,student_number',
        ]);

        // 1) Create User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->student_number), // password = student number
            'role'     => 'student',
        ]);

        // 2) Create Student record
        Student::create([
            'user_id'        => $user->id,
            'student_number' => $request->student_number,
            // optional: if your students table also has 'name', add it:
            // 'name' => $request->name,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student added successfully!');
    }

    // ✅ EDIT
    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email,' . $student->user_id,
            'student_number' => 'required|string|max:50|unique:students,student_number,' . $student->id,
        ]);

        // Update User
        if ($student->user) {
            $student->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
        }

        // Update Student
        $student->update([
            'student_number' => $request->student_number,
            // optional: if students table has 'name', update it too:
            // 'name' => $request->name,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully!');
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $student = Student::with('user')->findOrFail($id);

        // delete linked user (cascade if set, but safe to do manually)
        if ($student->user) {
            $student->user->delete();
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully!');
    }
}
