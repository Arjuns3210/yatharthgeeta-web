<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audios', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('audio_category_id')->unsigned()->nullable();
            $table->string('cover_image')->nullable();
            $table->string('file_name')->nullable();
            $table->string('srt_file_name')->nullable();
            $table->enum('has_episodes', [1, 0])->default(1);
            $table->text('people_also_read_ids')->nullable();
            $table->string('duration')->nullable();
            $table->integer('language_id')->unsigned()->nullable();
            $table->integer('author_id')->unsigned()->nullable();
            $table->string('sequence')->nullable();
            $table->integer('narrator_id')->unsigned()->nullable();
            $table->integer('views')->default(0);

            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('audios');
    }
}
