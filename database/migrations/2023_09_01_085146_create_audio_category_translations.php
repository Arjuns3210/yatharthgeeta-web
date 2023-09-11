<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioCategoryTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('audio_category_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['audio_category_id','locale']);
            $table->foreign('audio_category_id')->references('id')->on('audio_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_category_translation');
    }
}
