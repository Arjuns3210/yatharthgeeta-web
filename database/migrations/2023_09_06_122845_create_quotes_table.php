<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quote_category_id');
            $table->foreign('quote_category_id')->references('id')->on('quote_categories')->onDelete('cascade');
			$table->unsignedInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->integer('artist_id')->default(1);
            $table->longText('image');
            $table->integer('sequence');
            $table->enum('status', [1, 0])->default(1);
			$table->enum('visible_on_app' ,[1,0])->default(1);
            $table->enum('share_allowed', ['Y', 'N'])->default('Y');
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
        Schema::dropIfExists('quotes');
    }
}
