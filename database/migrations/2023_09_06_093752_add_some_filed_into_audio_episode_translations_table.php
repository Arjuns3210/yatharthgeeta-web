<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFiledIntoAudioEpisodeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_episode_translations', function (Blueprint $table) {
            // Add new columns
            $table->string('chapter_name')->after('chapters')->nullable();
            $table->string('verses_name')->after('verses')->nullable();
            $table->integer('chapter_number')->after('chapter_name')->nullable();
            $table->integer('verses_number')->after('verses')->nullable();
            
            //drop column
            $table->dropColumn('chapters');
            $table->dropColumn('verses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_episode_translations', function (Blueprint $table) {
            // Add new columns
            $table->string('chapters')->after('chapter_name')->nullable();
            $table->string('verses')->after('verses_name')->nullable();

            //drop column
            $table->dropColumn('chapter_name');
            $table->dropColumn('verses_name');
            $table->dropColumn('chapter_number');
            $table->dropColumn('verse_number');
        });
    }
}
