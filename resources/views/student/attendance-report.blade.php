@extends('layouts.admin')

@section('title', 'Attendance Report')

@section('content')

<div class="card p-3">
    <h4>Attendance Report – {{ $subject->name }}</h4>
</div>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Lecture Date</th>
            <th>Status</th>
            <th>Marked At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lectures as $lecture)

            @php
                $att = $attendance[$lecture->id] ?? null;
            @endphp

            <tr>
                <!-- ✅ FIXED: lecture date -->
                <td>
                    {{ \Carbon\Carbon::parse($lecture->start_time)->format('Y-m-d') }}
                </td>

                <!-- ✅ FIXED: status check -->
                <td>
                    @if($att && $att->status === 'present')
                        <span class="badge bg-success">Present</span>
                    @else
                        <span class="badge bg-danger">Absent</span>
                    @endif
                </td>

                <!-- ✅ FIXED: scanned_at -->
                <td>
                    @if($att && $att->scanned_at)
                        {{ \Carbon\Carbon::parse($att->scanned_at)->format('Y-m-d h:i A') }}
                    @else
                        -
                    @endif
                </td>
            </tr>

        @endforeach
    </tbody>
</table>

@endsection
