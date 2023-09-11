<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AddAudioPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_permission = [
            'name' => 'Audios',
            'codename' => 'audios',
            'parent_status' => 'parent',
            'description' => '',
            'status' => '1'
        ];

        $result = Permission::firstOrCreate($parent_permission);
        $permissions = [
            [
                'name' => 'Add',
                'codename' => 'audios_add',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'Edit',
                'codename' => 'audios_edit',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'View',
                'codename' => 'audios_view',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'Status',
                'codename' => 'audios_status',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'Delete',
                'codename' => 'audios_delete',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'Manage Audio Episode',
                'codename' => 'manage_audio_episodes',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}
