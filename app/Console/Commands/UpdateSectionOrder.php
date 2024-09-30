<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateSectionOrder extends Command
{
    protected $signature = 'sections:update-order';
    protected $description = 'Update the order of sections based on their course_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting to update section order...');

        // Retrieve distinct course_ids from sections table
        $courses = DB::table('sections')
            ->select('course_id')
            ->distinct()
            ->get();

        foreach ($courses as $course) {
            // Retrieve sections for the current course_id
            $sections = DB::table('sections')
                ->where('course_id', $course->course_id)
                ->orderBy('created_at') // Use appropriate column to define order
                ->get();

            // Update the order column for each section
            foreach ($sections as $index => $section) {
                DB::table('sections')
                    ->where('id', $section->id)
                    ->update(['order' => $index + 1]);
            }
        }

        $this->info('Section order updated successfully.');
    }
}
