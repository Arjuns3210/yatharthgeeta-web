<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('video_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->time('duration');
            $table->string('description');
            $table->foreignId('author_id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('narrator_id')->unsigned()->nullable();
            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->unique(['video_id','locale']);
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
        Schema::dropIfExists('video_translations');
    }
}
