@extends('layouts.admin')

@section('title', 'Edit Lecturer')

@section('content')

<div class="card">
    <h3>Edit Lecturer</h3>
    <p>Update lecturer details below.</p>

    <form method="POST" action="{{ route('admin.lecturers.update', $lecturer->id) }}">
        @csrf
        @method('PUT')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $lecturer->user->name }}" required>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $lecturer->user->email }}" required>

        <label>Lecturer ID:</label>
        <input type="text" name="lecturer_id" value="{{ $lecturer->lecturer_id }}" required>

        <label>Department:</label>
        <select name="department">
            <option value="IT"      {{ $lecturer->department == 'IT' ? 'selected' : '' }}>IT</option>
            <option value="BBM"     {{ $lecturer->department == 'BBM' ? 'selected' : '' }}>BBM</option>
            <option value="English" {{ $lecturer->department == 'English' ? 'selected' : '' }}>English Department</option>
        </select>

        <button type="submit" class="btn btn-primary">Update Lecturer</button>
    </form>
</div>

@endsection
