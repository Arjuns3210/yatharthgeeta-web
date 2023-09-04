<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_collections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->string('no_of_images');
            $table->enum('type', ['single', 'multiple', 'ebook', 'audio_books', 'videos', 'shloks'])->default('single');
            $table->integer('sequence')->nullable();
            $table->json('extra_details')->nullable()->comment('JSON Data');
            $table->enum('orientation', ['horizontal', 'vertical'])->default('horizontal');
            $table->enum('status', [0, 1])->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_collections');
    }
}
