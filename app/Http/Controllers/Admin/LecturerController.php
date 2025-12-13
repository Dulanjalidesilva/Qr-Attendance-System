<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('user')->get();
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $departments = ['IT', 'BBM', 'English'];
        return view('admin.lecturers.create', compact('departments'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name'          => 'required',
        'email'         => 'required|email|unique:users',
        'lecturer_id'   => 'required|unique:lecturers',
        'department'    => 'required'
    ]);

    // Create user with lecturer_id as password
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->lecturer_id),   // ← IMPORTANT
        'role'     => 'lecturer',
    ]);

    Lecturer::create([
        'user_id'      => $user->id,
        'lecturer_id'  => $request->lecturer_id,
        'department'   => $request->department,
    ]);

    return redirect()->route('admin.lecturers.index')
        ->with('success', 'Lecturer created successfully!');
}


    public function edit($id)
    {
        $lecturer = Lecturer::with('user')->findOrFail($id);
        $departments = ['IT', 'BBM', 'English'];
        return view('admin.lecturers.edit', compact('lecturer', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $user = $lecturer->user;

        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'lecturer_id' => 'required|unique:lecturers,lecturer_id,' . $lecturer->id,
            'department'  => 'required',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
        ]);

        $lecturer->update([
            'lecturer_id' => $request->lecturer_id,
            'department'  => $request->department,
        ]);

        return redirect()->route('admin.lecturers.index')
            ->with('success', 'Lecturer updated successfully!');
    }

    public function destroy($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $lecturer->user->delete();
        $lecturer->delete();

        return redirect()->route('admin.lecturers.index')
            ->with('success', 'Lecturer deleted successfully!');
    }
}
