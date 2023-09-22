<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile_no', 10);
            $table->string('mobile_no_with_code', 20);
            $table->integer('otp_code');
            $table->datetime('expiry_time');
            $table->string('workflow');
            $table->integer('verify_count');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('otps');
    }
}
