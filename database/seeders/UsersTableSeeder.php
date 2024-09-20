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
        // Insert or update a user with the “teacher” role
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@teacher.com'],
            [
                'firstname' => 'Teacher',
                'middlename' => 'Teacher',
                'lastname' => 'Teacher',
                'password' => Hash::make('teacher'),
                'role' => 'teacher',
            ]
        );

        // Insert or update a user with the “student” role
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@student.com'],
            [
                'firstname' => 'Student',
                'middlename' => 'Student',
                'lastname' => 'Student',
                'password' => Hash::make('student'),
                'role' => 'student',
            ]
        );
    }
}
