<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'content' => $this->faker->text,
            'course_id' => \App\Models\Course::factory(),
            'section_id' => \App\Models\Section::factory(),
            'module_id' => \App\Models\Module::factory(),


        ];
    }
}
