<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('is_verified');
            $table->dropColumn('email');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->after('name');
            $table->string('phone_code', 10)->default('91')->after('email');
            $table->renameColumn('email_verified_at', 'phone_verified_at');
            $table->string('password')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->enum('gender', ['M', 'F', 'O'])->default('M')->after('phone');
            $table->string('city')->default('Mumbai')->change()->after('gender');
            $table->string('state')->nullable()->change()->after('city');
            $table->enum('is_verified', ['Y', 'N'])->default('N')->after('last_login');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
