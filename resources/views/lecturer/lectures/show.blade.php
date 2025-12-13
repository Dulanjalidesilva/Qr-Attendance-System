@extends('layouts.admin')

@section('title', 'Lecture QR Code')

@section('content')

@php
$qrUrl = route('student.scan', $lecture->id);
@endphp

<div class="card">
    <h2>{{ $lecture->subject->name }} — QR Code</h2>

    <p><strong>Date:</strong> {{ $lecture->start_time }}</p>
    <p><strong>Valid Until:</strong> {{ $lecture->end_time }}</p>

    <center>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($qrUrl) }}">
</center>

    <br>

    <a class="btn btn-primary" href="{{ route('lecturer.lectures.index') }}">
        Back to My Lectures
    </a>
</div>

@endsection
