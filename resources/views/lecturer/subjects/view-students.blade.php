@extends('layouts.admin')

@section('title', 'View Students')

@section('content')

<div class="card" style="margin-top:20px; padding:20px;">

    <h3>
        Students Enrolled in {{ $subject->code }} - {{ $subject->name }}
    </h3>

    @if($subject->students->count())
        <table class="table table-bordered" style="margin-top:20px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Email</th>
                    <th>Student Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subject->students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <!-- ✅ FIXED: email from users table -->
                        <td>{{ $student->user->email }}</td>

                        <td>{{ $student->student_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No students assigned to this subject yet.</p>
    @endif

</div>

@endsection
