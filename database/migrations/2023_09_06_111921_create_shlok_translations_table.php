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
            $table->id();
            $table->unsignedBigInteger('shlok_id');
            $table->foreign('shlok_id')->references('id')->on('shloks')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('description');
            $table->string('chapter');
            $table->unique(['shlok_id','locale']);
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
