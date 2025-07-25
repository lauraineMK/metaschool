<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::orderByDesc('created_at')->paginate(15);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function show($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('admin.quizzes.show', compact('quiz'));
    }

    public function validateQuiz($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->status = 'validated';
        $quiz->save();
        return redirect()->back()->with('success', 'Quiz validé.');
    }

    public function rejectQuiz($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->status = 'rejected';
        $quiz->save();
        return redirect()->back()->with('success', 'Quiz rejeté.');
    }
}
