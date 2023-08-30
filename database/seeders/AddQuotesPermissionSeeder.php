<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
class AddQuotesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parent_permission = [
            'name' => 'Quotes',
            'codename' => 'quotes',
            'parent_status' => 'parent',
            'description' => '',
            'status' => '1'
        ];
        $result = Permission::firstOrCreate($parent_permission);

        $permissions = [
        	[
	            'name' => 'Add',
	            'codename' => 'quotes_add',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'Edit',
	            'codename' => 'quotes_edit',
	            'parent_status' => $result->id,
	            'description' => '',
	            'status' => '1'
	        ],
	        [
	            'name' => 'View',
	            'codename' => 'quotes_view',
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
