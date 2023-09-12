<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('video_category_id');
            $table->foreign('video_category_id')->references('id')->on('video_categories')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['video_category_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_category_translations');
    }
}
