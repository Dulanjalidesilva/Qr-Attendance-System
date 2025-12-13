<h1>Edit Student</h1>

<form method="POST" action="{{ route('admin.students.update', $student->id) }}">
    @csrf
    @method('PUT')

    <label>Name:</label>
    <input type="text" name="name" value="{{ $student->user->name }}" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ $student->user->email }}" required><br><br>

    <label>Student Number:</label>
    <input type="text" name="student_number" value="{{ $student->student_number }}" required><br><br>

    <button type="submit">Update</button>
</form>
