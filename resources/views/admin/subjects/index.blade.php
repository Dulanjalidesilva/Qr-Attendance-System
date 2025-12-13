@extends('layouts.admin')

@section('title', 'Subjects List')

@section('content')


<div class="table-container">

    <h2 style="margin-bottom:15px;">Subjects List</h2>

    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">+ Add Subject</a>

    <table>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Lecturer</th>
            <th>Lecturer ID</th>
            <th>Actions</th>
        </tr>

        @foreach($subjects as $subject)
        <tr>
            <td>{{ $subject->code }}</td>
            <td>{{ $subject->name }}</td>

            <td>
                @if($subject->lecturer)
                    {{ $subject->lecturer->user->name }}
                @else
                    -
                @endif
            </td>

            <td>
                @if($subject->lecturer)
                    {{ $subject->lecturer->lecturer_id }}
                @else
                    -
                @endif
            </td>

            <td>
                <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-secondary">Edit</a>

                <form action="{{ route('admin.subjects.destroy', $subject->id) }}"
                      method="POST"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Delete this subject?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>

</div>

@endsection
