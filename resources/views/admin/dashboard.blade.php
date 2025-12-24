@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="card-grid">

    <!-- STUDENTS CARD -->
    <div class="card">
        <h3>Students</h3>
        <p>Total Registered: <strong>{{ $students }}</strong></p>
        <p>Register and manage students</p>

        
    </div>

    <!-- LECTURERS CARD -->
    <div class="card">
        <h3>Lecturers</h3>
        <p>Total Registered: <strong>{{ $lecturers }}</strong></p>
        <p>Register and manage lecturers</p>

        
    </div>

    <!-- SUBJECTS CARD -->
    <div class="card">
        <h3>Subjects</h3>
        <p>Total Subjects: <strong>{{ $subjects }}</strong></p>
        <p>Add and manage subjects</p>
    </div>

</div>


<!-- FUNCTIONAL SECTIONS -->
<div class="card-grid">

    <!-- STUDENT MANAGEMENT SECTION -->
    <div class="card">
        <h3>1. Students Management</h3>

        <p>
            Register new students, update details, and manage existing student records.
        </p>

        <a class="btn btn-primary" href="{{ route('admin.students.index') }}">Go to Students</a>
    </div>


    <!-- LECTURER & SUBJECT MANAGEMENT SECTION -->
    <div class="card">
        <h3>2. Lecturers & Subjects</h3>

        <p>
            Register lecturers, manage their details, and assign or create subjects.
        </p>

        <a class="btn btn-secondary" href="{{ route('admin.lecturers.index') }}">Go to Lecturers</a>
        <a class="btn btn-primary" style="margin-left:10px;" href="{{ route('admin.subjects.index') }}">Go to Subjects</a>
    </div>

</div>


<div class="card-grid">

    <!-- ATTENDANCE TRACKING -->
    <div class="card">
        <h3>3. Attendance Tracking</h3>

        <p>
            Track and view student attendance records using their student number.
        </p>

        <a href="{{ route('admin.attendance.index') }}" class="btn btn-primary btn-sm">
    Attendance Tracking
    </a>

    </div>

    <!-- LOGIN DETAILS -->
    <div class="card">
        <h3>4. Lecture Login Details</h3>

        <p>
            Configure and view email, student ID, and lecturer ID used for lecture logins.
        </p>

        <a href="{{ route('admin.login.config') }}" class="btn btn-secondary">
            Configure Login Details
        </a>

    </div>

</div>

@endsection
