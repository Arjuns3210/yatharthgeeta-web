<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned();
            $table->longText('cover_image');
            $table->integer('views')->unsigned()->nullable();
            $table->integer('duration');
            $table->string('link');
            $table->integer('sequence');
            $table->enum('visible_on_app', [0, 1])->default(1);
            $table->enum('status', [1, 0])->default(1);
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
