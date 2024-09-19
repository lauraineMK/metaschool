<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = [
            ['firstname' => 'Alice', 'middlename' => 'E.', 'lastname' => 'Brown', 'email' => 'alice.brown@example.com', 'password' => 'password123'],
            ['firstname' => 'Robert', 'middlename' => 'F.', 'lastname' => 'Davis', 'email' => 'robert.davis@example.com', 'password' => 'password123'],
            ['firstname' => 'Linda', 'middlename' => 'G.', 'lastname' => 'Miller', 'email' => 'linda.miller@example.com', 'password' => 'password123'],
            ['firstname' => 'James', 'middlename' => 'H.', 'lastname' => 'Wilson', 'email' => 'james.wilson@example.com', 'password' => 'password123'],
        ];

        foreach ($teachers as $teacher) {
            User::create([
                'firstname' => $teacher['firstname'],
                'middlename' => $teacher['middlename'],
                'lastname' => $teacher['lastname'],
                'email' => $teacher['email'],
                'password' => Hash::make($teacher['password']),
                'role' => 'teacher',
            ]);
        }
    }
}
