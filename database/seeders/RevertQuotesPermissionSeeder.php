<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class RevertQuotesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        	'quotes',
        	'quotes_add',
        	'quotes_edit',
        	'quotes_view',
            'quotes_status',
            'quotes_delete'
        ];
        $permissionData = Permission::whereIn('codename', $permissions)->pluck('id');
        foreach ($permissionData as $permission) {
        	Permission::find($permission)->delete();
        }
    }
}
