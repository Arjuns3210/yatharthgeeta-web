<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShloksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shloks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('background_image')->nullable();
            $table->integer('sequence');
            $table->enum('share_allowed', ['yes', 'no'])->default('yes');
            $table->longText('sanskrit_title')->nullable();
            $table->integer('verses_number')->nullable();
            $table->integer('chapter_number')->nullable();
            $table->integer('audio_episode_id')->nullable();
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
        Schema::dropIfExists('shloks');
    }
}
