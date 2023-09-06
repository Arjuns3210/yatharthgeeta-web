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
        Schema::dropIfExists('shlok_translations');
    }
}
