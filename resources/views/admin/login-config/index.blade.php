@extends('layouts.admin')

@section('title', 'Lecture Login Details')

@section('content')

<div class="card" style="padding:20px;">
    <h3>Configure Lecture Login Details</h3>
    <p style="color:#666;">Update email addresses used by students and lecturers to log in.</p>

    @if(session('success'))
        <div class="alert alert-success" style="margin-top:10px;">
            {{ session('success') }}
        </div>
    @endif
</div>

<div class="card" style="margin-top:20px; padding:20px;">
    <h3>Lecturer Login Emails</h3>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Current Email</th>
                <th>Update</th>
            </tr>
        </thead>

        <tbody>
            @foreach($lecturers as $lec)
                <tr>
                    <td>{{ $lec->name }}</td>
                    <td>{{ $lec->email }}</td>

                    <td>
                        <form action="{{ route('admin.login.config.update') }}" method="POST" style="display:flex; gap:10px;">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $lec->id }}">
                            <input type="email" name="email" placeholder="New email…" required>
                            <button class="btn btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div class="card" style="margin-top:20px; padding:20px;">
    <h3>Student Login Emails</h3>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Student ID</th>
                <th>Current Email</th>
                <th>Update</th>
            </tr>
        </thead>

        <tbody>
            @foreach($students as $stu)
                <tr>
                    <td>{{ $stu->name }}</td>
                    <td>{{ $stu->student->student_number }}</td>
                    <td>{{ $stu->email }}</td>

                    <td>
                        <form action="{{ route('admin.login.config.update') }}" method="POST" style="display:flex; gap:10px;">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $stu->id }}">
                            <input type="email" name="email" placeholder="New email…" required>
                            <button class="btn btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
