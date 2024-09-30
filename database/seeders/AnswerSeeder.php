<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the course names which answers should be created for
        $courseNames = [
            'Introduction to Programming',
            'Advanced Data Structures',
            'Introduction to Data Science',
        ];

        // Retrieve questions only for quizzes associated with the specified courses
        $questions = Question::whereHas('quiz.lesson.course', function ($query) use ($courseNames) {
            $query->whereIn('name', $courseNames);
        })->get();

        foreach ($questions as $question) {
            // Check the type of the question
            if ($question->type === 'multiple_choice') {
                // Create sample answers for multiple choice questions
                Answer::firstOrCreate([
                    'question_id' => $question->id,
                    'answer_text' => 'Sample Answer 1 for ' . $question->question_text,
                    'is_correct' => true, // Mark as correct answer
                ]);

                Answer::firstOrCreate([
                    'question_id' => $question->id,
                    'answer_text' => 'Sample Answer 2 for ' . $question->question_text,
                    'is_correct' => false, // Mark as incorrect answer
                ]);

                Answer::firstOrCreate([
                    'question_id' => $question->id,
                    'answer_text' => 'Sample Answer 3 for ' . $question->question_text,
                    'is_correct' => false, // Mark as incorrect answer
                ]);
            } elseif ($question->type === 'open') {
                // For open questions, you can choose to add a default answer or leave it empty
                Answer::firstOrCreate([
                    'question_id' => $question->id,
                    'answer_text' => '', // Open questions do not typically have predefined answers
                    'is_correct' => false,
                ]);
            }
        }
    }
}
