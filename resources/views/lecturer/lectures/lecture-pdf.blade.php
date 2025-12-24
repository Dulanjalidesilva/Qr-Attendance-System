<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lecture Attendance Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h2>Lecture Attendance Report</h2>

<p><strong>Subject:</strong> {{ $lecture->subject->code }} - {{ $lecture->subject->name }}</p>
<p><strong>Lecture Start:</strong> {{ \Carbon\Carbon::parse($lecture->start_time)->format('Y-m-d h:i A') }}</p>
<p><strong>Lecture End:</strong> {{ \Carbon\Carbon::parse($lecture->end_time)->format('Y-m-d h:i A') }}</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Student Email</th>
            <th>Status</th>
            <th>Scanned At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $student)
            @php
                $att = $attendance[$student->id] ?? null;
                $status = $att ? 'PRESENT' : 'ABSENT';
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->user->email }}</td>
                <td>{{ $status }}</td>
                <td>{{ $att ? \Carbon\Carbon::parse($att->scanned_at)->format('h:i A') : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
