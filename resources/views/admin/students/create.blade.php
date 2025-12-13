@extends('layouts.admin')

@section('title', 'Add Student')

@section('content')

<h1>Add Student</h1>

<form method="POST" action="{{ route('admin.students.store') }}">
    @csrf

    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Student Number:</label>
    <input type="text" name="student_number" required><br><br>

    <button type="submit" class="btn btn-primary">Register Student</button>
</form>

@endsection
