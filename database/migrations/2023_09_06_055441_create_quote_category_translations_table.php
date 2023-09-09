<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quote_category_id');
            $table->foreign('quote_category_id')->references('id')->on('quote_categories')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['quote_category_id','locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_category_translations');
    }
}
