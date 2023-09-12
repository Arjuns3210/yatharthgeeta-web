<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsIntoAudioEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_episodes', function (Blueprint $table) {
            // Add new columns
            $table->text('main_shlok')->after('srt_file_name')->nullable();
            $table->text('explanation_shlok')->after('main_shlok')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_episodes', function (Blueprint $table) {
            // drop new columns
            $table->dropColumn('main_shlok');
            $table->dropColumn('explanation_shlok');
        });
    }
}
