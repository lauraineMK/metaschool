<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = 'admin@metaschool.local';
        $adminPassword = 'admin1234'; // À changer en prod !

        $exists = DB::table('users')->where('email', $adminEmail)->exists();
        if (!$exists) {
            DB::table('users')->insert([
                'firstname' => 'Admin',
                'lastname' => 'MetaSchool',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
