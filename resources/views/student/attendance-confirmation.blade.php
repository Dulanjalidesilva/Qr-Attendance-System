@extends('layouts.admin')

@section('title', 'Attendance Confirmed')

@section('content')

<div class="container mt-5">
    <div class="card shadow text-center p-4">

        <h2 class="text-success mb-3">
            ✅ Attendance Marked Successfully
        </h2>

        <hr>

        <p><strong>Subject:</strong> {{ $attendance->lecture->subject->name }}</p>
        <p><strong>Lecture Date:</strong>
            {{ \Carbon\Carbon::parse($attendance->lecture->start_time)->format('Y-m-d') }}
        </p>

        <p><strong>Time Marked:</strong>
            {{ \Carbon\Carbon::parse($attendance->scanned_at)->format('h:i A') }}
            
        </p>

        <p class="mt-3">
            Reflect your attendance report for confirmation.
        </p>

        <a href="{{ route('student.attendance.subject', $attendance->lecture->subject_id) }}"
           class="btn btn-primary mt-3">
            View Attendance Report
        </a>

    </div>
</div>

@endsection
