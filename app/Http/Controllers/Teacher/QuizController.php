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
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $quizzes = Quiz::all();
        return view('teacher.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $lessons = Lesson::all();
        return view('teacher.quizzes.create', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming request containing quiz data.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());
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

        // dd($validatedData);

        // Quiz creation within a transaction
        DB::transaction(function () use ($validatedData, $request) {
            // Quiz creation
            $quiz = Quiz::create([
                'lesson_id' => $validatedData['lesson_id'],
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
            ]);

            // dd($validatedData['title'], $validatedData['description']);

            // Add questions and answers
            foreach ($validatedData['questions'] as $questionData) {
                // Create question
                $question = $quiz->questions()->create([
                    'type' => $questionData['type'],
                    'question_text' => $questionData['text'],
                ]);

                // If it's a multiple-choice question, handle answers
                if ($questionData['type'] === 'multiple_choice' && isset($questionData['answers'])) {
                    foreach ($questionData['answers'] as $answerData) {
                        $question->answers()->create([
                            'answer_text' => $answerData['text'],
                            'is_correct' => isset($answerData['is_correct']) ? $answerData['is_correct'] : false,
                        ]);
                    }
                }

                // If it's an open-ended question, save the expected answer
                elseif ($questionData['type'] === 'open') {
                    $question->answers()->create([
                        'answer_text' => $questionData['answer_text'],
                        'is_correct' => false, // Open-ended questions generally have no correct/incorrect answer
                    ]);
                }
            }
        });
        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id  The ID of the quiz to display.
     * @return \Illuminate\View\View
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
     *
     * @param  string  $id  The ID of the quiz to edit.
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $lessons = Lesson::all(); // Retrieve all lessons
        return view('teacher.quizzes.edit', compact('quiz', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming request containing updated quiz data.
     * @param  string  $id  The ID of the quiz to update.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id  The ID of the quiz to remove.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        //
    }
}
