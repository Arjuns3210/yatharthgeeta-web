<?php

use Illuminate\Database\Migrations\Migration;

class MigrationToRunSeederToAddAudioEpisodePermissionSeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('db:seed', [
            '--class' => 'AddAudioEpisodePermissionSeeder',
            '--force' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Artisan::call('db:seed', [
            '--class' => 'RevertAudioEpisodePermissionSeeder',
            '--force' => true
        ]);
    }
}
