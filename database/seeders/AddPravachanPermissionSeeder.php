<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AddPravachanPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_permission = [
            'name' => 'Pravachan',
            'codename' => 'pravachan',
            'parent_status' => 'parent',
            'description' => '',
            'status' => '1'
        ];

        $result = Permission::firstOrCreate($parent_permission);
        $permissions = [
            [
                'name' => 'Add',
                'codename' => 'pravachan_add',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'Edit',
                'codename' => 'pravachan_edit',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'View',
                'codename' => 'pravachan_view',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'Status',
                'codename' => 'pravachan_status',
                'parent_status' => $result->id,
                'description' => '',
                'status' => '1'
            ],
            [
                'name' => 'Delete',
                'codename' => 'pravachan_delete',
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
