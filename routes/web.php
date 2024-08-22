<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SectionController;


Route::get('/', function () {
    return view('home');
});

// Teacher and student dashboards
Route::get('/teachers/dashboard', [CourseController::class, 'teacher_dashboard'])->name('teacher.dashboard');
Route::get('/students/dashboard', [CourseController::class, 'student_dashboard'])->name('student.dashboard');


Route::prefix('teachers')->middleware('role:teacher')->group(function () {
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);
    Route::post('courses', [CourseController::class, 'store']);
    Route::put('courses/{id}', [CourseController::class, 'update']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);

    Route::get('lessons', [LessonController::class, 'index']);
    Route::get('lessons/{id}', [LessonController::class, 'show']);
    Route::post('lessons', [LessonController::class, 'store']);
    Route::put('lessons/{id}', [LessonController::class, 'update']);
    Route::delete('lessons/{id}', [LessonController::class, 'destroy']);
});
