<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_translations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('audio_id')->unsigned();
            $table->foreign('audio_id')->references('id')
                ->on('audios')->onDelete('cascade')->onUpdate('cascade');
            $table->string('locale')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_translations');
    }
}
