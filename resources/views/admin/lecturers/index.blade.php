@extends('layouts.admin')

@section('title', 'Lecturers List')

@section('content')

<div class="table-box">
    <a class="btn btn-primary" href="{{ route('admin.lecturers.create') }}">Add Lecturer</a>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Lecturer ID</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>

        @foreach($lecturers as $l)
        <tr>
            <td>{{ $l->user->name }}</td>
            <td>{{ $l->user->email }}</td>
            <td>{{ $l->lecturer_id }}</td>
            <td>{{ $l->department }}</td>

            <td>
                <a class="btn btn-secondary" href="{{ route('admin.lecturers.edit', $l->id) }}">Edit</a>

                <form action="{{ route('admin.lecturers.destroy', $l->id) }}" method="POST" style="display:inline;">
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
