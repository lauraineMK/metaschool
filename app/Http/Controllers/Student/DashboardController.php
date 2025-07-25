<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Progress;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Récupère le cours en cours (exemple: le premier cours inscrit)
        $course = Course::whereHas('lessons')->first();
        // Progression fictive (à adapter selon ta logique)
        $progress = 0;
        $nextLesson = null;
        if ($course) {
            $lessons = $course->lessons->sortBy('order');
            $completedCount = Progress::where('user_id', Auth::id())
                ->whereIn('lesson_id', $lessons->pluck('id'))
                ->where('completed', true)
                ->count();
            $progress = $lessons->count() > 0 ? round($completedCount / $lessons->count() * 100) : 0;
            foreach ($lessons as $lesson) {
                if ($lesson instanceof \App\Models\Lesson) {
                    $completed = Progress::where('user_id', Auth::id())
                        ->where('lesson_id', $lesson->id)
                        ->where('completed', true)
                        ->exists();
                    if (!$completed) {
                        $nextLesson = $lesson;
                        break;
                    }
                }
            }
        }
        return view('students.dashboard', compact('course', 'progress', 'nextLesson'));
    }
}
