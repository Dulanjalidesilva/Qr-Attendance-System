@extends('layouts.admin')

@section('title', 'Edit Lecturer')

@section('content')

<div class="card">
    <h3>Edit Lecturer</h3>
    <p>Update Subject details below.</p>



    <form method="POST" action="{{ route('admin.subjects.update', $subject->id) }}">
        @csrf
        @method('PUT')

        <div class="grid">

            <div class="group">
                <label>Subject Code</label>
                <input
                    type="text"
                    name="code"
                    value="{{ old('code', $subject->code) }}"
                    required
                >
            </div>

            <div class="group">
                <label>Subject Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $subject->name) }}"
                    required
                >
            </div>

            <div class="group full">
                <label>Lecturer</label>
                <select name="lecturer_id" required>
                    <option value="">-- Select Lecturer --</option>

                    @foreach($lecturers as $lecturer)
                        <option
                            value="{{ $lecturer->id }}"
                            {{ old('lecturer_id', $subject->lecturer_id) == $lecturer->id ? 'selected' : '' }}
                        >
                            {{ $lecturer->name }} ({{ $lecturer->lecturer_id ?? $lecturer->id }})
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="actions">
            <a href="{{ route('admin.subjects.index') }}" class="btnx btn-secondary">
                ⬅ Back
            </a>

            <button type="submit" class="btnx btn-primary">
                ✅ Update Subject
            </button>
        </div>
    </form>


@endsection
