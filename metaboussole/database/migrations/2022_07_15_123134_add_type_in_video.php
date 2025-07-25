<?php

use App\Doctrine\Entities\Text;
use App\Doctrine\Entities\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeInVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->enum('type', Video::TYPES)
                  ->nullable(false)
                  ->default(Video::TYPE_NEW);
            // Suppression des lignes dropForeign et dropIndex car la clé et l'index n'existent pas
        });

        Schema::table('text', function (Blueprint $table) {
            $table->enum('type', Text::TYPES)
                  ->nullable(false)
                  ->default(Text::TYPE_NEW);
            $table->dropForeign('text_site_id_fk');
            $table->dropIndex('text_site_id_ref_uindex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video', function (Blueprint $table) {
            $table->dropColumn('type');
        });
        Schema::table('text', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
