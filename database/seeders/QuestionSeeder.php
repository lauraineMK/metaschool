<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the course names which questions should be created for
        $courseNames = [
            'Introduction to Programming',
            'Advanced Data Structures',
            'Introduction to Data Science',
        ];

        // Retrieve quizzes only for the specified courses
        $quizzes = Quiz::whereHas('lesson.course', function ($query) use ($courseNames) {
            $query->whereIn('name', $courseNames);
        })->get();

        foreach ($quizzes as $quiz) {
            // Create an open-ended question for each quiz
            Question::create([
                'quiz_id' => $quiz->id,
                'type' => 'open',
                'question_text' => 'What is your opinion on ' . $quiz->title . '?', // Open-ended question
            ]);

            // Create a multiple-choice question for each quiz
            Question::create([
                'quiz_id' => $quiz->id,
                'type' => 'multiple_choice',
                'question_text' => 'Which of the following is a feature of ' . $quiz->title . '?', // Multiple-choice question
            ]);
        }

        // Exemple pour le cours "Introduction to Programming"
        $quiz = \App\Models\Quiz::whereHas('lesson.course', function($q) {
            $q->where('name', 'Introduction to Programming');
        })->first();
        if ($quiz) {
            // Question 1
            \App\Models\Question::create([
                'quiz_id' => $quiz->id,
                'type' => 'multiple_choice',
                'question_text' => 'Qu\'est-ce qu\'une variable en programmation ?'
            ]);
            // Question 2
            \App\Models\Question::create([
                'quiz_id' => $quiz->id,
                'type' => 'multiple_choice',
                'question_text' => 'Quel langage est principalement utilisé pour le web côté client ?'
            ]);
            // Question 3
            \App\Models\Question::create([
                'quiz_id' => $quiz->id,
                'type' => 'multiple_choice',
                'question_text' => 'À quoi sert une boucle for ?'
            ]);
        }
    }
}
