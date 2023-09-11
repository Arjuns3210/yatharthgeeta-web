<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_category_id')->unsigned();
            $table->longText('cover_image');
            $table->longText('pdf_file_name');
            $table->longText('epub_file_name')->nullable();
            $table->enum('download_allowed', [1, 0])->default(0);
            $table->unsignedInteger('artist_id');
            $table->integer('pages');
            $table->integer('sequence');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('audio_id')->comment('comma separated audio ids');
            $table->longText('video_id')->comment('comma separated video ids');
            $table->longText('related_id')->comment('comma separated book ids');
            $table->enum('visible_on_app', [0, 1])->default(1);
            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('book_category_id')->references('id')->on('book_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('books');
    }
}
