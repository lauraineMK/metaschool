<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array of course names
        $courseNames = [
            'Introduction to Programming',
            'Advanced Data Structures',
            'Introduction to Data Science',
        ];

        foreach ($courseNames as $courseName) {
            $course = Course::where('name', $courseName)->first();

            if ($course) {
                // Get all course lessons
                $lessons = $course->lessons;

                foreach ($lessons as $lesson) {
                    // Create a quiz for each lesson
                    Quiz::firstOrCreate([
                        'title' => 'Quiz for ' . $lesson->title,
                        'description' => 'A quiz to test your knowledge on ' . $lesson->title,
                        'lesson_id' => $lesson->id,
                    ]);
                }
            }
        }
    }
}
