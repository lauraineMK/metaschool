<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AuthenticationController;


Route::get('/', function () {
    return view('home');
});

// Auth Routes
Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthenticationController::class, 'register']);


// Teacher and student dashboards
Route::get('/teachers/dashboard', [CourseController::class, 'teacher_dashboard'])->name('teacher.dashboard');
Route::get('/students/dashboard', [CourseController::class, 'student_dashboard'])->name('student.dashboard');

// Teacher routes
//! Issue: Middleware problem to be dealt with delicately
Route::prefix('teachers')->middleware('role:teacher')->group(function () {
    // Teacher dashboard

    // Routes for managing courses
    Route::get('courses', [CourseController::class, 'index'])->name('teacher.courses.index');
    Route::get('courses/{id}', [CourseController::class, 'show'])->name('teacher.courses.show');
    Route::post('courses', [CourseController::class, 'store'])->name('teacher.courses.store');
    Route::put('courses/{id}', [CourseController::class, 'update'])->name('teacher.courses.update');
    Route::delete('courses/{id}', [CourseController::class, 'destroy'])->name('teacher.courses.destroy');

    // Routes for managing lessons
    Route::get('lessons', [LessonController::class, 'index'])->name('teacher.lessons.index');
    Route::get('lessons/{id}', [LessonController::class, 'show'])->name('teacher.lessons.show');
    Route::post('lessons', [LessonController::class, 'store'])->name('teacher.lessons.store');
    Route::put('lessons/{id}', [LessonController::class, 'update'])->name('teacher.lessons.update');
    Route::delete('lessons/{id}', [LessonController::class, 'destroy'])->name('teacher.lessons.destroy');
});

// Student routes

    // Student dashboard

    // Routes for managing courses

    // Routes for managing lessons

// Verification route for php information
Route::get('/phpinfo', function () {
    phpinfo();
});
