<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateModuleOrder extends Command
{
    protected $signature = 'modules:update-order';
    protected $description = 'Update the order of modules based on their course_id';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting to update module order...');

        $courses = DB::table('modules')
            ->select('course_id')
            ->distinct()
            ->get();

        foreach ($courses as $course) {
            $modules = DB::table('modules')
                ->where('course_id', $course->course_id)
                ->orderBy('created_at') // Or any other column to define the order
                ->get();

            foreach ($modules as $index => $module) {
                DB::table('modules')
                    ->where('id', $module->id)
                    ->update(['order' => $index + 1]);
            }
        }

        $this->info('Module order updated successfully.');
    }
}
