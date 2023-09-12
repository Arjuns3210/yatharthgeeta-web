<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class RevertEventImagePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        	'event_image',
        	'event_image_add',
        	'event_image_edit',
        	'event_image_view',
        	'event_image_status',
        	'event_image_delete'
        ];
        $permissionData = Permission::whereIn('codename', $permissions)->pluck('id');
        foreach ($permissionData as $permission) {
        	Permission::find($permission)->delete();
        }
    }
}
