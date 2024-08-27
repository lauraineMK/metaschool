<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (DB::table('users')->where('email', 'admin@teacher.com')->doesntExist()) {
            DB::table('users')->insert([
                'firstname' => 'Teacher',
                'surname' => 'Teacher',
                'email' => 'admin@teacher.com',
                'password' => Hash::make('teacher'),
                'role' => 'teacher',
            ]);
        }

        if (DB::table('users')->where('email', 'admin@student.com')->doesntExist()) {
            DB::table('users')->insert([
                'firstname' => 'Student',
                'surname' => 'Student',
                'email' => 'admin@student.com',
                'password' => Hash::make('student'),
                'role' => 'student',
            ]);
        }
    }
}
