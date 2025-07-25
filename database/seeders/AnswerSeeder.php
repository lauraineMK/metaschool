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

        // Réponses pour les questions du quiz 'Introduction to Programming'
        $quiz = \App\Models\Quiz::whereHas('lesson.course', function($q) {
            $q->where('name', 'Introduction to Programming');
        })->first();
        if ($quiz) {
            $questions = $quiz->questions;
            // Question 1
            $q1 = $questions->where('question_text', "Qu'est-ce qu'une variable en programmation ?")->first();
            if ($q1) {
                \App\Models\Answer::create(['question_id' => $q1->id, 'answer_text' => 'Un espace pour stocker une valeur', 'is_correct' => true]);
                \App\Models\Answer::create(['question_id' => $q1->id, 'answer_text' => 'Un type de boucle', 'is_correct' => false]);
                \App\Models\Answer::create(['question_id' => $q1->id, 'answer_text' => 'Un opérateur mathématique', 'is_correct' => false]);
            }
            // Question 2
            $q2 = $questions->where('question_text', 'Quel langage est principalement utilisé pour le web côté client ?')->first();
            if ($q2) {
                \App\Models\Answer::create(['question_id' => $q2->id, 'answer_text' => 'JavaScript', 'is_correct' => true]);
                \App\Models\Answer::create(['question_id' => $q2->id, 'answer_text' => 'PHP', 'is_correct' => false]);
                \App\Models\Answer::create(['question_id' => $q2->id, 'answer_text' => 'Python', 'is_correct' => false]);
            }
            // Question 3
            $q3 = $questions->where('question_text', 'À quoi sert une boucle for ?')->first();
            if ($q3) {
                \App\Models\Answer::create(['question_id' => $q3->id, 'answer_text' => 'Répéter une action plusieurs fois', 'is_correct' => true]);
                \App\Models\Answer::create(['question_id' => $q3->id, 'answer_text' => 'Déclarer une variable', 'is_correct' => false]);
                \App\Models\Answer::create(['question_id' => $q3->id, 'answer_text' => 'Arrêter un programme', 'is_correct' => false]);
            }
        }
    }
}
