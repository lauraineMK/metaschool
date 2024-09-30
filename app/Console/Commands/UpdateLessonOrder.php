<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateLessonOrder extends Command
{
    protected $signature = 'lessons:update-order';
    protected $description = 'Update the order of lessons based on their course_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting to update lesson order...');

        $courses = DB::table('lessons')
            ->select('course_id')
            ->distinct()
            ->get();

        foreach ($courses as $course) {
            $lessons = DB::table('lessons')
                ->where('course_id', $course->course_id)
                ->orderBy('created_at') // Or any other column to define the order
                ->get();

            foreach ($lessons as $index => $lesson) {
                DB::table('lessons')
                    ->where('id', $lesson->id)
                    ->update(['order' => $index + 1]);
            }
        }

        $this->info('Lesson order updated successfully.');
    }
}
