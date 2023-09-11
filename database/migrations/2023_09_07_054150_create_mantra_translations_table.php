<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantraTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantra_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mantra_id')->unsigned();
            $table->string('locale')->index();
            $table->longText('title');
            $table->longText('description');
            $table->foreign('mantra_id')->references('id')->on('mantras')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['mantra_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantra_translations');
    }
}
