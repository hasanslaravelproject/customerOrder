<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list companies']);
        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'update companies']);
        Permission::create(['name' => 'delete companies']);

        Permission::create(['name' => 'list orders']);
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'update orders']);
        Permission::create(['name' => 'delete orders']);

        Permission::create(['name' => 'list menucategories']);
        Permission::create(['name' => 'view menucategories']);
        Permission::create(['name' => 'create menucategories']);
        Permission::create(['name' => 'update menucategories']);
        Permission::create(['name' => 'delete menucategories']);

        Permission::create(['name' => 'list units']);
        Permission::create(['name' => 'view units']);
        Permission::create(['name' => 'create units']);
        Permission::create(['name' => 'update units']);
        Permission::create(['name' => 'delete units']);

        Permission::create(['name' => 'list menus']);
        Permission::create(['name' => 'view menus']);
        Permission::create(['name' => 'create menus']);
        Permission::create(['name' => 'update menus']);
        Permission::create(['name' => 'delete menus']);

        Permission::create(['name' => 'list allfood']);
        Permission::create(['name' => 'view allfood']);
        Permission::create(['name' => 'create allfood']);
        Permission::create(['name' => 'update allfood']);
        Permission::create(['name' => 'delete allfood']);

        Permission::create(['name' => 'list fixedfoods']);
        Permission::create(['name' => 'view fixedfoods']);
        Permission::create(['name' => 'create fixedfoods']);
        Permission::create(['name' => 'update fixedfoods']);
        Permission::create(['name' => 'delete fixedfoods']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
