@extends('layouts.admin')

@section('title', 'Add Lecturer')

@section('content')

<div class="card">
    <h3>Add Lecturer</h3>
    <p>Fill the form below to register a new lecturer.</p>

    <form method="POST" action="{{ route('admin.lecturers.store') }}">
        @csrf

        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter lecturer name" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter lecturer email" required>

        <label>Lecturer ID (Also used as password):</label>
        <input type="text" name="lecturer_id" placeholder="Enter lecturer ID" required>

        <label>Department:</label>
        <select name="department" required>
            <option value="">-- Select Department --</option>
            <option value="IT">IT</option>
            <option value="BBM">BBM</option>
            <option value="English">English Department</option>
        </select>

        <button type="submit" class="btn btn-primary">Register Lecturer</button>
    </form>
</div>

@endsection
