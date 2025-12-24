@extends('layouts.admin')

@section('title', 'Edit Lecturer')

@section('content')

<div class="card">
    <h3>Edit Lecturer</h3>
    <p>Update Student details below.</p>

    <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
    @csrf
    @method('PUT')

    <label>Name:</label>
    <input type="text" name="name" value="{{ $student->user->name }}" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ $student->user->email }}" required><br><br>

    <label>Student Number:</label>
    <input type="text" name="student_number" value="{{ $student->student_number }}" required><br><br>

    <div class="actions">
            <a href="{{ route('admin.subjects.index') }}" class="btnx btn-secondary">
                ⬅ Back
            </a>

    <button type="submit" class="btnx btn-primary">
                ✅ Update Subject
            </button>
</form>
</div>

@endsection
