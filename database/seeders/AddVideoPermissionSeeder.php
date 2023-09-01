<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AddVideoPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_permission = [
            'name' => 'Videos',
            'codename' => 'videos',
            'parent_status' => 'parent',
            'description' => '',
            'status' => '1'
        ];
        $result = Permission::firstOrCreate($parent_permission);

        $permissions = [
        	[
	            'name' => 'Add',
	            'codename' => 'videos_add',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'Edit',
	            'codename' => 'videos_edit',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'View',
	            'codename' => 'videos_view',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'Status',
	            'codename' => 'videos_status',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'Delete',
	            'codename' => 'videos_status',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ]
        ];

        foreach ($permissions as $permission) {
        	Permission::firstOrCreate($permission);
        }
    }
}
