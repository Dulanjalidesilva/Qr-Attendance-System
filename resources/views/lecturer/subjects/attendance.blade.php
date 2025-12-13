@extends('layouts.admin')

@section('title', 'Attendance - ' . $subject->name)

@section('content')

<div class="card" style="margin-top:20px; padding:20px;">

    <h3>Attendance for {{ $subject->code }} - {{ $subject->name }}</h3>

    @if($lectures->count() == 0)
        <p>No lectures have been created for this subject yet.</p>
    @else

        <table class="table table-bordered" style="margin-top:20px;">
            <thead>
                <tr>
                    <th>Student</th>

                    @foreach ($lectures as $lec)
                        <th>
                            {{ \Carbon\Carbon::parse($lec->start_time)->format('M d') }}
                            <br>
                            <small>{{ \Carbon\Carbon::parse($lec->start_time)->format('h:i A') }}</small>
                        </th>
                    @endforeach

                    <th>Total Present</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($subject->students as $student)

                    <tr>
                        <td>{{ $student->name }}</td>

                        @php
                            $presentCount = 0;
                        @endphp

                        @foreach ($lectures as $lecture)

                            @php
                                $isPresent = $attendance->where('lecture_id', $lecture->id)
                                                       ->where('student_id', $student->id)
                                                       ->first();
                            @endphp

                            <td class="{{ $isPresent ? 'text-success' : 'text-danger' }}">
                                {{ $isPresent ? '✔' : '✘' }}
                            </td>

                            @php
                                if ($isPresent) $presentCount++;
                            @endphp

                        @endforeach

                        <td><strong>{{ $presentCount }}</strong></td>

                    </tr>

                @endforeach
            </tbody>
        </table>

    @endif

</div>

@endsection
