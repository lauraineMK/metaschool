<?php

namespace App\Http\Controllers\Student;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return view('student.quizzes.index', compact('quizzes'));
    }

    /**
     * Display the specified quiz.
     *
     * @param  int  $id  The ID of the quiz to show.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Retrieve the quiz by its ID
        $quiz = Quiz::findOrFail($id);

        // Retrieve the associated lesson for the quiz
        $lesson = $quiz->lesson;

        // Retrieve previous and next quizzes for navigation
        $previousQuiz = Quiz::where('id', '<', $quiz->id)->orderBy('id', 'desc')->first();
        $nextQuiz = Quiz::where('id', '>', $quiz->id)->orderBy('id', 'asc')->first();

        // Retrieve quiz questions
        $questions = $quiz->questions;

        // Pass data to the student quiz view
        return view('student.quizzes.show', compact('quiz', 'lesson', 'previousQuiz', 'nextQuiz', 'questions'));
    }

    /**
     * Submit the user's answers for the specified quiz and calculate the score.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming request containing user answers.
     * @param  int  $id  The ID of the quiz being submitted.
     * @return \Illuminate\View\View
     */
    public function submit(Request $request, $id)
    {
        // Retrieve the quiz by its ID
        $quiz = Quiz::with('questions.answers', 'lesson')->findOrFail($id);

        // Validation of answers
        $request->validate([
            'questions.*' => 'required|exists:answers,id',
        ]);

        // Initialize the score
        $score = 0;

        // Retrieve the user's answers
        $userAnswers = $request->input('questions', []);

        // Check the answers
        foreach ($quiz->questions as $question) {
            if ($question->type === 'open') {
                // For open questions, retrieve the user's answer
                // If the question is open, the answer is expected in the answers array
                if (isset($userAnswers[$question->id]) && !empty($userAnswers[$question->id])) {
                    // Here, you can add grading logic for open answers if necessary
                    $score++; // You can adjust this logic according to your criteria
                }
            } else {
                // For multiple-choice questions
                $correctAnswer = $question->answers->where('is_correct', true)->first();
                if (isset($userAnswers[$question->id]) && $userAnswers[$question->id] == $correctAnswer->id) {
                    $score++;
                }
            }
        }

        // Pass the score and the answers to the results view
        return view('student.quizzes.results', [
            'quiz' => $quiz,
            'score' => $score,
            'userAnswers' => $userAnswers,
            'lesson' => $quiz->lesson
        ]);
    }
}
