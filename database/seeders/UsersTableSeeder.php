<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert a user with the “teacher” role
        DB::table('users')->insert([
            'firstname' => 'Teacher',
            'surname' => 'Teacher',
            'email' => 'admin@teacher.com',
            'password' => Hash::make('teacher'),
            'role' => 'teacher',
        ]);

        // Insert a user with the “student” role
        DB::table('users')->insert([
            'firstname' => 'Student',
            'surname' => 'Student',
            'email' => 'admin@student.com',
            'password' => Hash::make('student'),
            'role' => 'student',
        ]);
    }
}
