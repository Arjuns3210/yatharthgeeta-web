<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RevertMantraPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        	'mantra',
        	'mantra_add',
        	'mantra_edit',
        	'mantra_view',
        	'mantra_status',
        	'mantra_delete'
        ];
        $permissionData = Permission::whereIn('codename', $permissions)->pluck('id');
        foreach ($permissionData as $permission) {
        	Permission::find($permission)->delete();
        }
    }
}
