<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('ashram');
            $table->json('phone')->nullable();
            $table->string('email');
            $table->string('image');
            $table->text('days')->nullable();
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('google_address');
            $table->integer('sequence');
            $table->enum('visible_on_app', [0, 1])->default(1);
            $table->enum('status', [0, 1])->default(1);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
