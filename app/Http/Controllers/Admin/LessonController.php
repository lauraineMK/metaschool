<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::orderByDesc('created_at')->paginate(15);
        return view('admin.lessons.index', compact('lessons'));
    }

    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('admin.lessons.show', compact('lesson'));
    }

    public function validateLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->status = 'validated';
        $lesson->save();
        return redirect()->back()->with('success', 'Leçon validée.');
    }

    public function rejectLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->status = 'rejected';
        $lesson->save();
        return redirect()->back()->with('success', 'Leçon rejetée.');
    }
}
