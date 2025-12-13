@extends('layouts.admin')

@section('title', 'Student Dashboard')

@section('content')

<div class="card" style="margin-top:20px;">
    <h3>Your Subjects</h3>

    @if(isset($subjects) && $subjects->count())
        <ul style="margin-top:10px; list-style-type: disc; padding-left: 20px;">

            @foreach($subjects as $subject)
                <li style="margin-bottom:15px;">

                    <strong>{{ $subject->code }} – {{ $subject->name }}</strong>

                    <br>

                    <a href="{{ route('student.attendance.subject', $subject->id) }}"
                       class="btn btn-primary"
                       style="margin-top:8px; padding:6px 12px;">
                        View Attendance
                    </a>

                </li>
            @endforeach

        </ul>
    @else
        <p>No subjects assigned.</p>
    @endif
</div>

@endsection
