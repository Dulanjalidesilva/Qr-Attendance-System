@extends('layouts.admin')

@section('title', 'Attendance Tracking')

@section('content')

<div class="card" style="padding:20px;">

    <h3>Search Student Attendance</h3>
    <p style="margin-bottom: 15px; color:#555;">Enter Student ID or Email</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.attendance.search') }}" method="POST">
        @csrf

        <label>Student ID or Email</label>
        <input type="text" name="keyword" placeholder="e.g.email@gmail.com" required>

        <button type="submit">Search</button>
    </form>

</div>

@endsection
