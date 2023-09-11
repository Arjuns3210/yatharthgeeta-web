<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_category_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['book_category_id','locale']);
            $table->foreign('book_category_id')->references('id')->on('book_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_category_translations');
    }
}
