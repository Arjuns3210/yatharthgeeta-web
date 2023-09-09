<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantras', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('sanskrit_title');
            $table->string('reference_name', 255)->default('Bhagvad Geeta');
            $table->string('reference_url', 255)->default('yatharthgeeta.com');
            $table->integer('sequence');
            $table->enum('status', [1, 0])->default(1);
            $table->enum('share_allowed', ['Y', 'N'])->default('Y');
            $table->enum('visible_on_app', [0, 1])->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('mantras');
    }
}
