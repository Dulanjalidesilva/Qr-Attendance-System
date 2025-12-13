@extends('layouts.admin')

@section('title', 'Attendance Records')

@section('content')

<div class="card" style="padding:20px;">
    <h3>Attendance for: {{ $student->name }} ({{ $student->student_number }})</h3>
    <p>Email: {{ $student->user->email }}</p>
</div>

<div class="table-box" style="margin-top:20px;">

    <h3>Attendance Summary</h3>

    @foreach($subjects as $subject)

        <h4 style="margin-top:20px;">{{ $subject->code }} – {{ $subject->name }}</h4>

        @php
            // Filter lectures belonging to this subject
            $subjectLectures = $lectures->where('subject_id', $subject->id);
        @endphp

        @if($subjectLectures->count() == 0)
            <p>No lectures created for this subject.</p>
            @continue
        @endif

        <table>
            <thead>
                <tr>
                    <th>Lecture Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
@foreach($subjectLectures as $lec)

    @php
        // Get attendance row with status = present
        $isPresent = $attendance
            ->where('lecture_id', $lec->id)
            ->where('status', 'present')
            ->first();
    @endphp

    <tr>
        <td>{{ \Carbon\Carbon::parse($lec->start_time)->format('M d, Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($lec->start_time)->format('h:i A') }}</td>

        <td>
            @if($isPresent)
                <span class="badge badge-success">✔ Present</span>
                <small style="color:#555;">
                 ({{ \Carbon\Carbon::parse($isPresent->scanned_at)->format('h:i A') }})
                </small>
            @else
                <span class="badge badge-danger">✘ Absent</span>
            @endif
        </td>
    </tr>

@endforeach
</tbody>

        </table>

    @endforeach

</div>

@endsection
