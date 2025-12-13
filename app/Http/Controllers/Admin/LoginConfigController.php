<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginConfigController extends Controller
{
    public function index()
    {
        // Show all lecturer and student login details
        $students = User::where('role', 'student')->with('student')->get();
        $lecturers = User::where('role', 'lecturer')->with('lecturer')->get();

        return view('admin.login-config.index', compact('students', 'lecturers'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'email'    => 'required|email',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Login details updated successfully!');
    }
}
