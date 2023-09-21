<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsShlokColumnInAudioEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_episodes', function (Blueprint $table) {
            $table->enum('is_shlok', ['1','0'])->default('0')->after('explanation_shlok');
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
            $table->dropColumn('is_shlok');
        });
    }
}
