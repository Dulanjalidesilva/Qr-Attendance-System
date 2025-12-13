@extends('layouts.admin')

@section('title', 'Start New Lecture')

@section('content')
<div class="card">
    <h3>Start New Lecture</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('lecturer.lectures.store') }}">
        @csrf

        <div class="form-group">
            <label>Subject</label>
            <select name="subject_id" required>
                <option value="">-- Select subject --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">
                        {{ $subject->code ?? $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Start time</label>
            <input type="datetime-local" name="start_time" required>
        </div>

        <div class="form-group">
            <label>End time</label>
            <input type="datetime-local" name="end_time" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Create Lecture & Generate QR
        </button>
    </form>
</div>
@endsection
