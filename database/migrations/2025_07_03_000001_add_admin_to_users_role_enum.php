<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Modifier l'ENUM pour ajouter 'admin' comme valeur possible
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('student', 'teacher', 'admin') NOT NULL DEFAULT 'student'");
    }

    public function down()
    {
        // Revenir à l'ENUM d'origine sans 'admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('student', 'teacher') NOT NULL DEFAULT 'student'");
    }
};
