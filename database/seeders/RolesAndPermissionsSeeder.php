<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'add category',
            'update category',
            'delete category'
        ];
        // Create Admin role
        $role = Role::firstOrCreate(['name' => 'admin']);

        //  Assign permission to Admin Role
        foreach($permissions as $permission){
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $role->givePermissionTo($perm);
         }

    }
}
