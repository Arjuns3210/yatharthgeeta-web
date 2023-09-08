<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class AddQuoteCategoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_permission = [
            'name' => 'quoteCategory',
            'codename' => 'quoteCategory',
            'parent_status' => 'parent',
            'description' => '',
            'status' => '1'
        ];
        $result = Permission::firstOrCreate($parent_permission);

        $permissions = [
            [
	            'name' => 'Add',
	            'codename' => 'quote_category_add',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
            [
	            'name' => 'Edit',
	            'codename' => 'quote_category_edit',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'View',
	            'codename' => 'quote_category_view',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'Status',
	            'codename' => 'quote_category_status',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
            [
	            'name' => 'Delete',
	            'codename' => 'quote_category_delete',
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
