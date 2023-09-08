<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioEpisodeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_episode_translations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('audio_episode_id')->unsigned();
            $table->foreign('audio_episode_id')->references('id')
                ->on('audio_episodes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('locale')->nullable();
            $table->string('title')->nullable();
            $table->string('chapters')->nullable();
            $table->string('verses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_episode_translations');
    }
}
