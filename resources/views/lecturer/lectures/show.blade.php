@extends('layouts.admin')

@section('title', 'Lecture QR Code')

@section('content')

@php
    use Illuminate\Support\Facades\URL;

    $qrUrl = URL::temporarySignedRoute(
        'student.scan',
        \Carbon\Carbon::parse($lecture->end_time),
        ['lecture_id' => $lecture->id]
    );
@endphp

<div class="card">

    <h2>{{ $lecture->subject->name }} — QR Code</h2>

    <p><strong>Date:</strong> {{ $lecture->start_time }}</p>
    <p><strong>Valid Until:</strong> {{ $lecture->end_time }}</p>

    <center>
        <img
            src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($qrUrl) }}"
            alt="Lecture QR Code"
        >
    </center>

    <br>

    {{-- ✅ LECTURE-WISE PDF DOWNLOAD --}}
    @if(\Carbon\Carbon::parse($lecture->end_time)->isPast())
        <a href="{{ route('lecturer.lectures.attendance.pdf', $lecture->id) }}"
           class="btn btn-danger mb-3">
            Download Lecture Attendance PDF
        </a>
    @else
        <p class="text-muted">
            Attendance PDF will be available after lecture ends.
        </p>
    @endif

    <br>

    <a class="btn btn-primary" href="{{ route('lecturer.lectures.index') }}">
        Back to My Lectures
    </a>

</div>

@endsection
