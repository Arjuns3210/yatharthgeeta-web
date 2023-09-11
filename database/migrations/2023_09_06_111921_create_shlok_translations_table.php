<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShlokTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shlok_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shlok_id')->unsigned();
            $table->foreign('shlok_id')->references('id')->on('shloks')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('description');
            $table->string('chapter');
            $table->unique(['shlok_id','locale']);
            $table->enum('status', [1, 0])->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shlok_translations');
    }
}
