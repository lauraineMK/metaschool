<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return view('teacher.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = Lesson::all();
        return view('teacher.quizzes.create', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        // Data validation
        $validatedData = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,open',
            'questions.*.answer_text' => 'required_if:questions.*.type,open|string', // For open questions
            'questions.*.answers' => 'required_if:questions.*.type,multiple_choice|array',
            'questions.*.answers.*.text' => 'required_if:questions.*.type,multiple_choice|string',
            'questions.*.answers.*.is_correct' => 'boolean',
        ]);

        // Check if there are any questions in the request
        if (empty($request->questions)) {
            return redirect()->back()->withInput()->withErrors(['error' => 'You must add at least one question.']);
        }

        // Quiz creation within a transaction
        DB::transaction(function () use ($validatedData, $request) {
            // Quiz creation
            $quiz = Quiz::create([
                'lesson_id' => $validatedData['lesson_id'],
                'title' => $request->title,
                'description' => $request->description,
            ]);

            // Add questions and answers
            foreach ($request->questions as $questionData) {
                // Create question
                $question = new Question();
                $question->quiz_id = $quiz->id;
                $question->type = $questionData['type'];
                $question->question_text = $questionData['text'];
                $question->save();

                // If it's a multiple-choice question, handle answers
                if ($question->type === 'multiple_choice' && isset($questionData['answers'])) {
                    foreach ($questionData['answers'] as $answerData) {
                        $answer = new Answer();
                        $answer->question_id = $question->id;
                        $answer->answer_text = $answerData['text'];
                        $answer->is_correct = isset($answerData['is_correct']) && $answerData['is_correct']; // Check that the answer is correct
                        $answer->save();
                    }
                }

                // If it's an open-ended question, save the expected answer
                elseif ($question->type === 'open') {
                    $answer = new Answer();
                    $answer->question_id = $question->id;
                    $answer->answer_text = $questionData['answer_text']; // Save open answer
                    $answer->is_correct = false; // Open-ended questions generally have no correct/incorrect answer
                    $answer->save();
                }
            }
        });
        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the quiz by its ID
        $quiz = Quiz::findOrFail($id);

        // Récupérer la leçon associée au quiz
        $lesson = $quiz->lesson;

        // Retrieve previous and next quizzes for navigation
        $previousQuiz = Quiz::where('id', '<', $quiz->id)->orderBy('id', 'desc')->first();
        $nextQuiz = Quiz::where('id', '>', $quiz->id)->orderBy('id', 'asc')->first();

        // Retrieve quiz questions
        $questions = $quiz->questions;

        return view('teacher.quizzes.show', compact('quiz', 'lesson', 'previousQuiz', 'nextQuiz', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
