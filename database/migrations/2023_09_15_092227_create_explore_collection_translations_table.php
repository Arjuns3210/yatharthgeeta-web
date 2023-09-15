<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExploreCollectionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('explore_collection_translations', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('explore_collection_id')->unsigned();
            $table->foreign('explore_collection_id')->references('id')->on('explore_collections')->onDelete('cascade')->onUpdate('cascade');
            $table->string('locale')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('explore_collection_translations');
    }
}
