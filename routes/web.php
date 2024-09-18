<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;

Route::middleware([RoleMiddleware::class])->group(function () {
    Route::get('/', function () {
        return view('home');
    })->withoutMiddleware([RoleMiddleware::class]);
});

// Auth Routes
Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthenticationController::class, 'register']);
Route::get('account', [AuthenticationController::class, 'index'])->name('account');

// Teacher routes
Route::prefix('teachers')->group(function () {
    // Teacher dashboard
    Route::get('/dashboard', [TeacherCourseController::class, 'teacher_dashboard'])->name('teacher.dashboard');
    // Routes for managing courses
    Route::get('courses', [TeacherCourseController::class, 'index'])->name('teacher.courses.index');
    Route::get('courses/create', [TeacherCourseController::class, 'create'])->name('teacher.courses.create');
    Route::post('courses', [TeacherCourseController::class, 'store'])->name('teacher.courses.store');
    Route::get('courses/{id}', [TeacherCourseController::class, 'show'])->name('teacher.courses.show');
    Route::get('courses/{id}/edit', [TeacherCourseController::class, 'edit'])->name('teacher.courses.edit');
    Route::put('courses/{id}', [TeacherCourseController::class, 'update'])->name('teacher.courses.update');
    Route::delete('courses/{id}', [TeacherCourseController::class, 'destroy'])->name('teacher.courses.destroy');

    // Routes for managing lessons
    Route::get('lessons', [TeacherLessonController::class, 'index'])->name('teacher.lessons.index');
    Route::get('lessons/create', [TeacherLessonController::class, 'create'])->name('teacher.lessons.create');
    Route::post('lessons', [TeacherLessonController::class, 'store'])->name('teacher.lessons.store');
    Route::get('lessons/{id}', [TeacherLessonController::class, 'show'])->name('teacher.lessons.show');
    Route::get('lessons/{id}/edit', [TeacherLessonController::class, 'edit'])->name('teacher.lessons.edit');
    Route::put('lessons/{id}', [TeacherLessonController::class, 'update'])->name('teacher.lessons.update');
    Route::delete('lessons/{id}', [TeacherLessonController::class, 'destroy'])->name('teacher.lessons.destroy');
})->middleware(RoleMiddleware::class);

// Student routes
Route::prefix('students')->group(function () {
    // Student dashboard
    Route::get('/dashboard', [StudentCourseController::class, 'student_dashboard'])->name('student.dashboard');
    // Routes for managing courses
    Route::get('courses', [StudentCourseController::class, 'index'])->name('student.courses.index');
    Route::get('courses/{id}', [StudentCourseController::class, 'show'])->name('student.courses.show');
    // Routes for managing lessons
    Route::get('lessons', [StudentLessonController::class, 'index'])->name('student.lessons.index');
    Route::get('lessons/{id}', [StudentLessonController::class, 'show'])->name('student.lessons.show');
})->middleware(RoleMiddleware::class);

// Verification route for php information
Route::get('/phpinfo', function () {
    phpinfo();
});
