<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSomeColumnIntoEventImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_images', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('sequence');
            $table->dropColumn('visible_in_app');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_images', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->enum('visible_in_app', [1, 0])->default(1);
            $table->integer('sequence')->nullable();
        });
    }
}
