<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Teacher\QuizController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Student\ProgressController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;

Route::get('/', function () {
    return view('home');
});

// Auth Routes
Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthenticationController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('account', [AuthenticationController::class, 'index'])->name('account');
    Route::put('/account/update', [AuthenticationController::class, 'update'])->name('account.update');
});

// Teacher routes
Route::prefix('teachers')->middleware(['auth', RoleMiddleware::class . ':teacher'])->group(function () {
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
    Route::delete('section/{id}', [TeacherCourseController::class, 'sectiondestroy'])->name('teacher.section.destroy');
    Route::delete('module/{id}', [TeacherCourseController::class, 'moduledestroy'])->name('teacher.module.destroy');

    // Routes for managing lessons
    Route::get('lessons', [TeacherLessonController::class, 'index'])->name('teacher.lessons.index');
    Route::get('lessons/create', [TeacherLessonController::class, 'create'])->name('teacher.lessons.create');
    Route::post('lessons', [TeacherLessonController::class, 'store'])->name('teacher.lessons.store');
    Route::get('lessons/{id}', [TeacherLessonController::class, 'show'])->name('teacher.lessons.show');
    Route::get('lessons/{id}/edit', [TeacherLessonController::class, 'edit'])->name('teacher.lessons.edit');
    Route::put('lessons/{id}', [TeacherLessonController::class, 'update'])->name('teacher.lessons.update');
    Route::delete('lessons/{id}', [TeacherLessonController::class, 'destroy'])->name('teacher.lessons.destroy');

    // Routes for managing quizzes
    Route::get('/quizzes', [QuizController::class, 'index'])->name('teacher.quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('teacher.quizzes.create');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('teacher.quizzes.store');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('teacher.quizzes.show');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('teacher.quizzes.edit');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('teacher.quizzes.update');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('teacher.quizzes.destroy');
});

// Student routes
Route::prefix('students')->middleware(['web', 'auth', RoleMiddleware::class . ':student'])->group(function () {
    // Student dashboard
    Route::get('/dashboard', [StudentCourseController::class, 'student_dashboard'])->name('student.dashboard');
    // Routes for managing courses
    Route::get('courses', [StudentCourseController::class, 'index'])->name('student.courses.index');
    Route::get('courses/{id}', [StudentCourseController::class, 'show'])->name('student.courses.show');
    // Routes for managing lessons
    Route::get('lessons', [StudentLessonController::class, 'index'])->name('student.lessons.index');
    Route::get('lessons/{id}', [StudentLessonController::class, 'show'])->name('student.lessons.show');
    Route::post('/progress', [ProgressController::class, 'store'])->name('student.progress.store');
});

// PHP Info (restricted to local environment)
if (app()->environment('local')) {
    Route::get('/phpinfo', function () {
        phpinfo();
    });
}
