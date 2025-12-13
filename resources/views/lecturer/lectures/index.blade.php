@extends('layouts.admin')

@section('title', 'My Lectures & QR Codes')

@section('content')

<div class="card">
    <h3>Your Lectures</h3>
</div>

<div class="card" style="margin-top:16px;">
    <a href="{{ route('lecturer.lectures.create') }}" class="btn btn-primary">+ Create New Lecture</a>
</div>

<br>

@if($lectures->count() == 0)
    <div class="card">
        <p>No lectures yet.</p>
    </div>

@else
    <table class="table">
        <tr>
            <th>Subject</th>
            <th>Start</th>
            <th>End</th>
            <th>QR Code</th>
        </tr>

        @foreach($lectures as $lecture)
        <tr>
            <td>{{ $lecture->subject->name }}</td>
            <td>{{ $lecture->start_time }}</td>
            <td>{{ $lecture->end_time }}</td>
            <td>
                <a href="{{ route('lecturer.lectures.show', $lecture->id) }}" class="btn btn-primary">
                    View QR
                </a>
                <form action="{{ route('lecturer.lectures.destroy', $lecture->id) }}"
                method="POST"style="display:inline-block"onsubmit="return confirm('Are you sure you want to delete this lecture?');">
             @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                 Delete
            </button>
    </form>
            </td>
        </tr>
        @endforeach
    </table>
@endif

@endsection
