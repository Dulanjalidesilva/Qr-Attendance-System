<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>

    <!-- SIDEBAR -->
    <!-- SIDEBAR -->
<div class="sidebar">

    {{-- Admin Panel --}}
    @if(auth()->check() && auth()->user()->role === 'admin')

        <h2>Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.students.index') }}">Students</a>
        <a href="{{ route('admin.lecturers.index') }}">Lecturers</a>
        <a href="{{ route('admin.subjects.index') }}">Subjects</a>

    {{-- Lecturer Panel --}}
    @elseif(auth()->check() && auth()->user()->role === 'lecturer')

        <h2>Lecturer Panel</h2>
        <a href="{{ route('lecturer.dashboard') }}">Dashboard</a>
        <a href="{{ route('lecturer.lectures.index') }}">My Lectures</a>
        <a href="{{ route('lecturer.logout') }}">Logout</a>

    {{-- Student Panel --}}
    @elseif(auth()->check() && auth()->user()->role === 'student')

        <h2>Student Panel</h2>

        <a href="{{ route('student.dashboard') }}">Dashboard</a>

        

        <a href="{{ route('student.logout') }}">Logout</a>

    @else
        <h2>Panel</h2>
    @endif

</div>


    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="navbar" style="display:flex; align-items:center; gap:18px;">

            <!-- SIBA LOGO -->
            <img src="/images/siba_logo.png"
                 alt="SIBA Logo"
                 style="height:50px; width:auto;">

                 

            <!-- PAGE TITLE -->
            <h1 style="margin:0; padding:0;">@yield('title')</h1>

            {{-- Right-side logout button --}}
            @if(auth()->check())
                <div style="margin-left:auto;">
                    @if(auth()->user()->role === 'admin')
                        <a href="/dev-login-admin" class="btn btn-secondary">Switch Admin</a>
                    @elseif(auth()->user()->role === 'lecturer')
                        <a href="{{ route('lecturer.logout') }}" class="btn btn-secondary">Logout</a>
                    @endif
                </div>
            @endif
        </div>

        @yield('content')
    </div>

</body>
</html>
