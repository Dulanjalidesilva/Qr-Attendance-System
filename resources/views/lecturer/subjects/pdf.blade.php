<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance PDF</title>

    <style>
        body { font-family: DejaVu Sans; font-size: 11px; }
        h3 { text-align: center; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h3>
    Attendance Report <br>
    {{ $subject->code }} – {{ $subject->name }}
</h3>

<table>
    <thead>
        <tr>
            <th>Student No</th>
            <th>Student Name</th>

            @foreach ($lectures as $lecture)
                <th>
                    {{ \Carbon\Carbon::parse($lecture->start_time)->format('M d') }} <br>
                    {{ \Carbon\Carbon::parse($lecture->start_time)->format('h:i A') }}
                    -
                    {{ \Carbon\Carbon::parse($lecture->end_time)->format('h:i A') }}
                </th>
            @endforeach

            <th>Total Present</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($subject->students as $student)

            @php $presentCount = 0; @endphp

            <tr>
                <td>{{ $student->student_number }}</td>
                <td>{{ $student->user->email }}</td>

                @foreach ($lectures as $lecture)

                    @php
                        // ✅ attendance is keyed: student_id-lecture_id
                        $key = $student->id . '-' . $lecture->id;
                        $isPresent = isset($attendance[$key]);

                        if ($isPresent) $presentCount++;
                    @endphp

                    <td>
                        {{ $isPresent ? '✔' : '✘' }}
                    </td>

                @endforeach

                <td><strong>{{ $presentCount }}</strong></td>
            </tr>

        @endforeach
    </tbody>
</table>

</body>
</html>
