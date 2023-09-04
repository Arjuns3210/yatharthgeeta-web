<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class AddLanguagePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_permission = [
            'name' => 'language ',
            'codename' => 'language',
            'parent_status' => 'parent',
            'description' => '',
            'status' => '1'
        ];
        $result = Permission::firstOrCreate($parent_permission);

        $permissions = [
            [
	            'name' => 'Add',
	            'codename' => 'language_add',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
            [
	            'name' => 'Edit',
	            'codename' => 'language_edit',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'View',
	            'codename' => 'language_view',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'Status',
	            'codename' => 'language_status',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
            [
	            'name' => 'Delete',
	            'codename' => 'language_delete',
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
