@extends('layouts.admin')

@section('title', 'Add Subject')

@section('content')

<div class="card">
    <h3>Add New Subject</h3>
</div>

<div class="card" style="margin-top:16px;">

    <form method="POST" action="{{ route('admin.subjects.store') }}">
        @csrf

        <label>Subject Code:</label>
        <input type="text" name="code" required>

        <label>Subject Name:</label>
        <input type="text" name="name" required>

        <label>Assign Lecturer:</label>
        <select name="lecturer_id" required>
            <option value="">-- Select Lecturer --</option>

            @foreach($lecturers as $lecturer)
                <option value="{{ $lecturer->id }}">
                    {{ $lecturer->user->name }} ({{ $lecturer->lecturer_id }})
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary" style="margin-top:10px;">
            Save Subject
        </button>

    </form>

</div>

@endsection
