<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = [
            ['firstname' => 'Eric', 'middlename' => 'M.', 'lastname' => 'Johnson', 'email' => 'eric.johnson@example.com', 'password' => 'password123'],
            ['firstname' => 'Anna', 'middlename' => 'L.', 'lastname' => 'Davis', 'email' => 'anna.davis@example.com', 'password' => 'password123'],
            ['firstname' => 'Michael', 'middlename' => 'C.', 'lastname' => 'Johnson', 'email' => 'michael.johnson@example.com', 'password' => 'password123'],
            ['firstname' => 'Emily', 'middlename' => 'D.', 'lastname' => 'Williams', 'email' => 'emily.williams@example.com', 'password' => 'password123'],
        ];

        foreach ($students as $student) {
            User::create([
                'firstname' => $student['firstname'],
                'middlename' => $student['middlename'],
                'lastname' => $student['lastname'],
                'email' => $student['email'],
                'password' => Hash::make($student['password']),
                'role' => 'student',
            ]);
        }
    }
}
