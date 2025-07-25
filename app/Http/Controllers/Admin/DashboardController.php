<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;

class DashboardController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')->with(['courses.lessons.quiz'])->get();
        $coursesCount = Course::count();
        $lessonsCount = Lesson::count();
        $quizzesCount = Quiz::count();
        $usersCount = User::count();
        $pendingCourses = Course::where('status', 'pending')->count();
        $pendingLessons = Lesson::where('status', 'pending')->count();
        $pendingQuizzes = Quiz::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'teachers', 'coursesCount', 'lessonsCount', 'quizzesCount', 'usersCount',
            'pendingCourses', 'pendingLessons', 'pendingQuizzes'
        ));
    }
}
