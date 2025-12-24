<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Attendance Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; }
        .left { text-align: left; }
    </style>
</head>
<body>

    <h2>Attendance Report - {{ $subject->code }} ({{ $subject->name }})</h2>
    <p><strong>Student:</strong> {{ auth()->user()->email }}</p>
    <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('Y-m-d h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th class="left">Lecture Date/Time</th>
                <th>Status</th>
                <th>Scanned At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lectures as $lec)
                @php
                    $att = $attendance[$lec->id] ?? null;
                    $isPresent = $att && $att->status === 'present' && $att->scanned_at;
                @endphp
                <tr>
                    <td class="left">
                        {{ \Carbon\Carbon::parse($lec->start_time)->format('Y-m-d h:i A') }}
                    </td>
                    <td>{{ $isPresent ? 'Present' : 'Absent' }}</td>
                    <td>{{ $att?->scanned_at ? \Carbon\Carbon::parse($att->scanned_at)->format('Y-m-d h:i A') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
