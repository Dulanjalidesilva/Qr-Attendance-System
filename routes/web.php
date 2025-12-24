<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\User;

// Lecturer Controllers
use App\Http\Controllers\Lecturer\LectureController;
use App\Http\Controllers\Lecturer\DashboardController as LecturerDashboard;

// Student Controllers
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;

/*
|--------------------------------------------------------------------------
| DEV AUTO LOGIN (TESTING MODE)
|--------------------------------------------------------------------------
*/
Route::get('/dev-login-admin', function () {
    $user = User::where('role', 'admin')->first();
    Auth::login($user);
    return redirect()->route('admin.dashboard');
});

Route::get('/dev-login-lecturer', function () {
    $user = User::where('role', 'lecturer')->first();
    Auth::login($user);
    return redirect()->route('lecturer.dashboard');
});

Route::get('/dev-login-student', function () {
    $user = User::where('role', 'student')->first();
    Auth::login($user);
    return redirect()->route('student.dashboard');
});

/*
|--------------------------------------------------------------------------
| LECTURER LOGIN ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/lecturer/login', function () {
    return view('auth.lecturer-login');
})->name('lecturer.login');

Route::post('/lecturer/login', function () {

    $user = User::where('email', request('email'))->first();

    if (!$user)
        return back()->withErrors(['error' => 'Email not found.']);

    if ($user->role !== 'lecturer')
        return back()->withErrors(['error' => 'This is not a lecturer account.']);

    if (!Auth::attempt(request(['email', 'password'])))
        return back()->withErrors(['error' => 'Invalid lecturer ID / password.']);

    return redirect()->route('lecturer.dashboard');

})->name('lecturer.login.submit');

Route::get('/lecturer/logout', function () {
    Auth::logout();
    return redirect()->route('lecturer.login');
})->name('lecturer.logout');

/*
|--------------------------------------------------------------------------
| STUDENT LOGIN ROUTES  ✅ FIXED (QR RESUME + SIGNED URL)
|--------------------------------------------------------------------------
*/
Route::get('/student/login', function () {
    return view('auth.student-login');
})->name('student.login');

Route::post('/student/login', function () {

    $user = User::where('email', request('email'))->first();

    if (!$user)
        return back()->withErrors(['error' => 'Email not found.']);

    if ($user->role !== 'student')
        return back()->withErrors(['error' => 'This account is not a student.']);

    if (!Auth::attempt(request(['email', 'password'])))
        return back()->withErrors(['error' => 'Invalid Student ID / password']);

    // ✅ If QR scan happened before login → resume scan (SIGNED URL REQUIRED)
    if (session()->has('qr_lecture_id')) {
        $lectureId = session('qr_lecture_id');
        session()->forget('qr_lecture_id');

        $signedUrl = URL::temporarySignedRoute(
            'student.scan',
            now()->addMinutes(10),
            ['lecture_id' => $lectureId]
        );

        return redirect($signedUrl);
    }

    return redirect()->route('student.dashboard');

})->name('student.login.submit');

Route::get('/student/logout', function () {
    Auth::logout();
    return redirect()->route('student.login');
})->name('student.logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard',
        [\App\Http\Controllers\Admin\DashboardController::class, 'index']
    )->name('dashboard');

    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);
    Route::resource('lecturers', \App\Http\Controllers\Admin\LecturerController::class);
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);

    Route::get('/attendance',
        [\App\Http\Controllers\Admin\AttendanceController::class, 'index']
    )->name('attendance.index');

    Route::post('/attendance/search',
        [\App\Http\Controllers\Admin\AttendanceController::class, 'search']
    )->name('attendance.search');

    Route::get('/login-config',
        [\App\Http\Controllers\Admin\LoginConfigController::class, 'index']
    )->name('login.config');

    Route::post('/login-config/update',
        [\App\Http\Controllers\Admin\LoginConfigController::class, 'update']
    )->name('login.config.update');
});

/*
|--------------------------------------------------------------------------
| LECTURER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('lecturer')->name('lecturer.')->group(function () {

    Route::get('/dashboard',
        [LecturerDashboard::class, 'index']
    )->name('dashboard');

    Route::get('/lectures', [LectureController::class, 'index'])
        ->name('lectures.index');

    Route::get('/lectures/create', [LectureController::class, 'create'])
        ->name('lectures.create');

    Route::post('/lectures/store', [LectureController::class, 'store'])
        ->name('lectures.store');

    Route::get('/lectures/{id}', [LectureController::class, 'show'])
        ->name('lectures.show');

    Route::delete('/lectures/{id}',[LectureController::class, 'destroy'])
        ->name('lectures.destroy');

    Route::get('/subject/{id}/attendance',
        [\App\Http\Controllers\Lecturer\SubjectAttendanceController::class, 'view']
    )->name('subject.attendance');

    // ✅ SUBJECT-WISE PDF (existing)
    Route::get('/subject/{id}/attendance/pdf',
        [\App\Http\Controllers\Lecturer\SubjectAttendanceController::class, 'exportPdf']
    )->name('subject.attendance.pdf');

    // ✅ NEW: LECTURE-WISE PDF (download only that lecture report)
    Route::get('/lectures/{id}/attendance/pdf',
        [\App\Http\Controllers\Lecturer\SubjectAttendanceController::class, 'exportLecturePdf']
    )->name('lectures.attendance.pdf');

    Route::get('/subject/{id}/students/add',
        [\App\Http\Controllers\Lecturer\SubjectStudentController::class, 'addStudents']
    )->name('subject.students.add');

    Route::post('/subject/{id}/students/add',
        [\App\Http\Controllers\Lecturer\SubjectStudentController::class, 'storeStudents']
    )->name('subject.students.store');

    Route::get('/subject/{id}/students',
        [\App\Http\Controllers\Lecturer\SubjectStudentController::class, 'viewStudents']
    )->name('subject.students.view');
});

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('student')->name('student.')->group(function () {

    Route::get('/scan/{lecture_id}',
        [AttendanceController::class, 'scan']
    )->name('scan')->middleware('signed');

    Route::middleware('auth')->group(function () {

        Route::get('/dashboard',
            [StudentDashboard::class, 'index']
        )->name('dashboard');

        Route::get('/attendance/confirmation/{id}',
            [AttendanceController::class, 'confirmation']
        )->name('attendance.confirmation');

        Route::get('/subject/{id}/attendance',
            [AttendanceController::class, 'view']
        )->name('attendance.subject');
    });
});

/*
|--------------------------------------------------------------------------
| DEFAULT ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('student.login');
});
