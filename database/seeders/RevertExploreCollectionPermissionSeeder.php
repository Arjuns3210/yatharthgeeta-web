<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class RevertExploreCollectionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'explore_collection',
            'explore_collection_add',
            'explore_collection_edit',
            'explore_collection_view',
            'explore_collection_status',
            'explore_collection_delete',
        ];
        $permissionData = Permission::whereIn('codename', $permissions)->pluck('id');
        foreach ($permissionData as $permission) {
            Permission::find($permission)->delete();
        }
    }
}
