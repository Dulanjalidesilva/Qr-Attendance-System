<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('lecturer.user')->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $lecturers = Lecturer::with('user')->get();
        return view('admin.subjects.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|unique:subjects,code',
            'name'        => 'required',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        Subject::create([
            'code'        => $request->code,
            'name'        => $request->name,
            'lecturer_id' => $request->lecturer_id,
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully!');
    }

    public function edit($id)
    {
        $subject   = Subject::findOrFail($id);
        $lecturers = Lecturer::with('user')->get();

        return view('admin.subjects.edit', compact('subject', 'lecturers'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'code'        => 'required|unique:subjects,code,' . $subject->id,
            'name'        => 'required',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $subject->update([
            'code'        => $request->code,
            'name'        => $request->name,
            'lecturer_id' => $request->lecturer_id,
        ]);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully!');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully!');
    }
}
