@extends('layouts.admin')

@section('title', 'Add Students')

@section('content')

<div class="card" style="margin-top:20px; padding:20px;">

    <h3>
        Add Students to {{ $subject->code }} – {{ $subject->name }}
    </h3>

    <form action="{{ route('lecturer.subject.students.store', $subject->id) }}" method="POST">
        @csrf

        @if($students->count())

            <table class="table table-bordered mt-4">
                <thead style="background:#6f2da8; color:white;">
                    <tr>
                        <th>#</th>
                        <th>Student Email</th>
                        <th>Student Number</th>
                        <th style="text-align:center;">Select</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <!-- ✅ email from users table -->
                            <td>{{ $student->user->email }}</td>

                            <td>{{ $student->student_number }}</td>

                            <td style="text-align:center;">
                                <input type="checkbox"
                                       name="student_ids[]"
                                       value="{{ $student->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success mt-3">
                Add Selected Students
            </button>

        @else
            <p class="text-muted mt-3">
                No students available to add.
            </p>
        @endif

    </form>

</div>

@endsection
