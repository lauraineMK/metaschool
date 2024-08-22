<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AuthenticationController;


Route::get('/', function () {
    return view('home');
});

// Auth Routes
Route::get('login', [App\Http\Controllers\AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\AuthenticationController::class, 'login']);
Route::post('logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [App\Http\Controllers\AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\AuthenticationController::class, 'register']);


// Teacher and student dashboards
Route::get('/teachers/dashboard', [CourseController::class, 'teacher_dashboard'])->name('teacher.dashboard');
Route::get('/students/dashboard', [CourseController::class, 'student_dashboard'])->name('student.dashboard');

// Teacher routes
Route::prefix('teachers')->middleware('role:teacher')->group(function () {
    // Teacher dashboard

    // Routes for managing courses
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);
    Route::post('courses', [CourseController::class, 'store']);
    Route::put('courses/{id}', [CourseController::class, 'update']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);

    // Routes for managing lessons
    Route::get('lessons', [LessonController::class, 'index']);
    Route::get('lessons/{id}', [LessonController::class, 'show']);
    Route::post('lessons', [LessonController::class, 'store']);
    Route::put('lessons/{id}', [LessonController::class, 'update']);
    Route::delete('lessons/{id}', [LessonController::class, 'destroy']);
});

// Student routes

    // Student dashboard
