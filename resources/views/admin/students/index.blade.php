@extends('layouts.admin')

@section('title', 'Students List')

@section('content')


<div class="table-box">
<a class="btn btn-primary" href="{{ route('admin.students.create') }}">+ Add Student</a>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Student Number</th>
        <th>Actions</th>
    </tr>

    @foreach($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->user->name }}</td>
            <td>{{ $student->user->email }}</td>
            <td>{{ $student->student_number }}</td>
            <td>
                
                <a class="btn btn-secondary" href="{{ route('admin.students.edit', $student->id) }}">Edit</a>

                <form action="{{ route('admin.students.destroy', $student->id) }}" 
                      method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach

</table>
</div>

@endsection
