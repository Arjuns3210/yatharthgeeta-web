<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->string('name');
            $table->string('locale');
            $table->string('short_description')->nullable();
            $table->string('long_description')->nullable();
            $table->text('allowed_in_location')->nullable();
            $table->text('not_allowed_in_location')->nullable();
            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_translations');
    }
}