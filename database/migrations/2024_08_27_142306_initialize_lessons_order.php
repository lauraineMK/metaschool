<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Initialize the order for existing lessons
        DB::table('lessons')->orderBy('created_at')->each(function ($lesson, $index) {
            DB::table('lessons')
                ->where('id', $lesson->id)
                ->update(['order' => $index + 1]); // +1 to start from 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally, you can reset the order if needed
        DB::table('lessons')->update(['order' => null]);
    }
};
