<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Progress;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function continue(Course $course)
    {
        $progress = 0;
        $user = Auth::user();
        $lessons = $course->lessons()->orderBy('order')->get();
        $nextLesson = null;
        foreach ($lessons as $lesson) {
            $completed = Progress::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->where('completed', true)
                ->exists();
            if (!$completed) {
                $nextLesson = $lesson;
                break;
            }
        }
        return view('courses.continue', compact('course', 'progress', 'nextLesson'));
    }
}
