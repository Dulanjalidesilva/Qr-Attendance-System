@extends('layouts.admin')

@section('title', 'Lecturer Dashboard')

@section('content')

<div class="card" style="
    margin-top:20px;
    padding:25px;
    border-radius:20px;
    background:#ffffff;
">

    <h3 style="
        margin-bottom:25px;
        font-weight:700;
        color:#4b0082;
    ">
        Your Subjects
    </h3>

    @if(isset($subjects) && $subjects->count())

        @foreach ($subjects as $subject)

            <div style="
                background:#ffffff;
                border:2px solid #e5dbff;
                padding:22px;
                border-radius:16px;
                margin-bottom:22px;
                transition:all 0.25s ease;
                box-shadow:0 4px 12px rgba(0,0,0,0.05);
            "
            onmouseover="this.style.boxShadow='0 8px 20px rgba(79,70,229,0.15)'; this.style.transform='translateY(-3px)'"
            onmouseout="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'"
            >

                <!-- SUBJECT TITLE -->
                <h4 style="
                    font-size:20px;
                    margin-bottom:16px;
                    font-weight:700;
                    color:#5b21b6;
                ">
                    {{ $subject->code }} – {{ $subject->name }}
                </h4>

                <!-- ACTION BUTTONS -->
                <div style="display:flex; gap:14px; flex-wrap:wrap;">

                    <a href="{{ route('lecturer.subject.attendance', $subject->id) }}"
                       class="btn"
                       style="
                            background:#4f46e5;
                            color:white;
                            padding:9px 20px;
                            border-radius:10px;
                       ">
                        View Attendance
                    </a>

                    <a href="{{ route('lecturer.lectures.create', ['subject_id' => $subject->id]) }}"
                       class="btn"
                       style="
                            background:#6d28d9;
                            color:white;
                            padding:9px 20px;
                            border-radius:10px;
                       ">
                        Start Lecture
                    </a>

                    <a href="{{ route('lecturer.subject.students.add', $subject->id) }}"
                       class="btn"
                       style="
                            background:#9333ea;
                            color:white;
                            padding:9px 20px;
                            border-radius:10px;
                       ">
                        Add Students
                    </a>

                    <a href="{{ route('lecturer.subject.students.view', $subject->id) }}"
                       class="btn"
                       style="
                            background:#7e22ce;
                            color:white;
                            padding:9px 20px;
                            border-radius:10px;
                       ">
                        View Students
                    </a>
                    <a href="{{ route('lecturer.subject.attendance.pdf', $subject->id) }}"
                    class="btn"
                    style="
                            background:#9333ea;
                            color:white;
                            padding:9px 20px;
                            border-radius:10px;
                        ">
                        Download Attendance PDF
                    </a>


                </div>

            </div>

        @endforeach

    @else
        <p class="text-muted">No subjects assigned.</p>
    @endif

</div>

@endsection
