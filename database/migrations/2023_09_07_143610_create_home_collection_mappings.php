<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeCollectionMappings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_collection_mappings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('home_collection_id');
            $table->longText('mapped_ids')->nullable();
            $table->integer('sequence')->nullable();
            $table->enum('is_clickable',[0,1])->default(0);
            $table->enum('mapped_to',['Book', 'Audio', 'Video', 'Shlok'])->nullable();
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
        Schema::dropIfExists('home_collection_mappings');
    }
}
