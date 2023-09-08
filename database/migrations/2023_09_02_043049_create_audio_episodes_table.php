<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_episodes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('audio_id')->unsigned();
            $table->foreign('audio_id')->references('id')
                ->on('audios')->onDelete('cascade')->onUpdate('cascade');
            $table->string('duration')->nullable();
            $table->integer('sequence')->nullable();
            $table->string('file_name')->nullable();
            $table->string('srt_file_name')->nullable();

            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_episodes');
    }
}
