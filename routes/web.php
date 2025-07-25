<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Student\ProgressController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Teacher\QuizController as TeacherQuizController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;
use App\Http\Controllers\VideoController;
use App\Models\Course;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;

Route::get('/courses/{course}/continue', [\App\Http\Controllers\CourseController::class, 'continue'])->name('courses.continue');

Route::get('/', function () {
    $courses = Course::all();
    // Récupérer les cours populaires (exemple : les 4 plus récents)
    $popularCourses = Course::latest()->take(4)->get();
    return view('home', compact('courses', 'popularCourses'));
});

// Route de changement de langue
Route::get('/lang/{locale}', [LanguageController::class, 'change']);

// Auth Routes
Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('register', [AuthenticationController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthenticationController::class, 'register']);

// Routes authentifiées
Route::middleware('auth')->group(function () {
    Route::get('account', [AuthenticationController::class, 'index'])->name('account');
    Route::put('/account/update', [AuthenticationController::class, 'update'])->name('account.update');
});

// Redirection automatique du dashboard selon le rôle
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'student') {
        return redirect()->route('student.dashboard');
    } elseif ($user->role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return view('dashboard');
    }
})->name('dashboard');

// Teacher routes
Route::prefix('teachers')->middleware(['auth', RoleMiddleware::class . ':teacher'])->group(function () {
    // Ajout de sections et modules
    Route::post('sections', [\App\Http\Controllers\Teacher\SectionController::class, 'store'])->name('teachers.sections.store');
    Route::post('modules', [\App\Http\Controllers\Teacher\ModuleController::class, 'store'])->name('teachers.modules.store');
    // Teacher dashboard
    Route::get('dashboard', [TeacherCourseController::class, 'teacher_dashboard'])->name('teacher.dashboard');

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
    Route::get('quizzes', [TeacherQuizController::class, 'index'])->name('teacher.quizzes.index');
    Route::get('quizzes/create', [TeacherQuizController::class, 'create'])->name('teacher.quizzes.create');
    Route::post('quizzes', [TeacherQuizController::class, 'store'])->name('teacher.quizzes.store');
    Route::get('quizzes/{quiz}', [TeacherQuizController::class, 'show'])->name('teacher.quizzes.show');
    Route::get('quizzes/{quiz}/edit', [TeacherQuizController::class, 'edit'])->name('teacher.quizzes.edit');
    Route::put('quizzes/{quiz}', [TeacherQuizController::class, 'update'])->name('teacher.quizzes.update');
    Route::delete('quizzes/{quiz}', [TeacherQuizController::class, 'destroy'])->name('teacher.quizzes.destroy');
});

// Student routes
Route::prefix('students')->middleware(['web', 'auth', RoleMiddleware::class . ':student'])->group(function () {
    // Student dashboard
    Route::get('dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');

    // Routes for managing courses
    Route::get('courses', [StudentCourseController::class, 'index'])->name('student.courses.index');
    Route::get('courses/{id}', [StudentCourseController::class, 'show'])->name('student.courses.show');

    // Routes for managing lessons
    Route::get('lessons', [StudentLessonController::class, 'index'])->name('student.lessons.index');
    Route::get('lessons/{id}', [StudentLessonController::class, 'show'])->name('student.lessons.show');

    // Routes for managing quizzes
    Route::get('quizzes', [StudentQuizController::class, 'index'])->name('student.quizzes.index');
    Route::get('quizzes/{id}', [StudentQuizController::class, 'show'])->name('student.quizzes.show');
    Route::post('quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('student.quizzes.submit');

    // Route for storing progress
    Route::post('/progress', [ProgressController::class, 'store'])->name('student.progress.store');

    // Mes cours (étudiant)
    Route::get('/students/courses', [StudentCourseController::class, 'myCourses'])->name('student.courses');

    // Marquer une leçon comme terminée (étudiant)
    Route::post('/students/lessons/{id}/complete', [\App\Http\Controllers\Student\LessonController::class, 'complete'])->name('student.lessons.complete');

    // Démarrer un cours (étudiant)
    Route::post('/students/courses/{id}/start', [\App\Http\Controllers\Student\CourseController::class, 'start'])->name('student.courses.start');
});

// Route de recherche de cours (pour la barre de recherche du header)
Route::get('/courses/search', function (\Illuminate\Http\Request $request) {
    $query = $request->input('q');
    // Redirige vers la liste des cours avec le paramètre de recherche (à adapter selon votre logique)
    return redirect()->route('students.courses.index', ['q' => $query]);
})->name('courses.search');

// Upload vidéo (enseignant)
Route::post('/lessons/{lesson}/video-upload', [VideoController::class, 'upload'])
    ->middleware(['auth', 'can:update,lesson'])
    ->name('lessons.video.upload');

// Streaming sécurisé (étudiant inscrit ou enseignant)
Route::get('/lessons/{lesson}/video', [VideoController::class, 'stream'])
    ->middleware(['auth'])
    ->name('lessons.video.stream');

// PHP Info (restricted to local environment)
if (app()->environment('local')) {
    Route::get('/phpinfo', function () {
        phpinfo();
    });
}

// Pages publiques : À propos et Contact
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Parcourir tous les cours (étudiant)
Route::get('/courses/browse', [StudentCourseController::class, 'browse'])->name('courses.browse');

// Route publique pour afficher tous les cours
// Route doublon supprimée : Route::get('courses', [App\Http\Controllers\Student\CourseController::class, 'browse'])->name('courses.browse');

// Page FAQ
Route::view('/faq', 'faq')->name('faq');

// Admin routes
Route::prefix('admin')->middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('courses', [AdminCourseController::class, 'index'])->name('admin.courses.index');
    Route::get('courses/create', [AdminCourseController::class, 'create'])->name('admin.courses.create');
    Route::post('courses', [AdminCourseController::class, 'store'])->name('admin.courses.store');
    Route::get('courses/{id}', [AdminCourseController::class, 'show'])->name('admin.courses.show');
    Route::post('courses/{id}/validate', [AdminCourseController::class, 'validateCourse'])->name('admin.courses.validate');
    Route::post('courses/{id}/reject', [AdminCourseController::class, 'rejectCourse'])->name('admin.courses.reject');
    Route::get('courses/{id}/edit', [AdminCourseController::class, 'edit'])->name('admin.courses.edit');
    Route::put('courses/{id}', [AdminCourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('courses/{id}', [AdminCourseController::class, 'destroy'])->name('admin.courses.destroy');

    Route::get('lessons', [AdminLessonController::class, 'index'])->name('admin.lessons.index');
    Route::get('lessons/create', [AdminLessonController::class, 'create'])->name('admin.lessons.create');
    Route::post('lessons', [AdminLessonController::class, 'store'])->name('admin.lessons.store');
    Route::get('lessons/{id}', [AdminLessonController::class, 'show'])->name('admin.lessons.show');
    Route::post('lessons/{id}/validate', [AdminLessonController::class, 'validateLesson'])->name('admin.lessons.validate');
    Route::post('lessons/{id}/reject', [AdminLessonController::class, 'rejectLesson'])->name('admin.lessons.reject');
    Route::get('lessons/{id}/edit', [AdminLessonController::class, 'edit'])->name('admin.lessons.edit');
    Route::put('lessons/{id}', [AdminLessonController::class, 'update'])->name('admin.lessons.update');
    Route::delete('lessons/{id}', [AdminLessonController::class, 'destroy'])->name('admin.lessons.destroy');

    Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::post('users/{id}/update-role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::post('users/{id}/delete', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('quizzes', [AdminQuizController::class, 'index'])->name('admin.quizzes.index');
    Route::get('quizzes/{id}', [AdminQuizController::class, 'show'])->name('admin.quizzes.show');
    Route::post('quizzes/{id}/validate', [AdminQuizController::class, 'validateQuiz'])->name('admin.quizzes.validate');
    Route::post('quizzes/{id}/reject', [AdminQuizController::class, 'rejectQuiz'])->name('admin.quizzes.reject');
});
