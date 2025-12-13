<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh; background:#e5e7eb;">

<div class="card" style="width:380px;">
    <h3>Student Login</h3>

    @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('student.login.submit') }}">
        @csrf

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Student ID (Password):</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn btn-primary" style="margin-top:10px;">
            Login
        </button>
    </form>
</div>

</body>
</html>
