<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions for brands
        Permission::create(['name' => 'create brand']);
        Permission::create(['name' => 'update brand']);
        Permission::create(['name' => 'delete brand']);
        Permission::create(['name' => 'view brand']);

        // create permissions for campaigns
        Permission::create(['name' => 'create campaign']);
        Permission::create(['name' => 'update campaign']);
        Permission::create(['name' => 'delete campaign']);
        Permission::create(['name' => 'view campaign']);
        Permission::create(['name' => 'publish campaign']);
        Permission::create(['name' => 'unpublish campaign']);

        // create permissions for locations
        Permission::create(['name' => 'create location']);
        Permission::create(['name' => 'update location']);
        Permission::create(['name' => 'delete location']);
        Permission::create(['name' => 'view location']);

        // create permissions for user
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view user']);
        
        // create roles and assign created permissions

        // create admin role and assign permissions
        $role = Role::create(['name' => 'admin'])
        	->givePermissionTo(['create campaign', 'update campaign', 'delete campaign', 'view campaign', 'publish campaign', 'unpublish campaign', 'create brand', 'update brand', 'delete brand', 'view brand', 'create location', 'update location', 'delete location', 'view location']);

        // create designer role and assign permissions
        $role = Role::create(['name' => 'designer'])
        	->givePermissionTo(['create campaign', 'update campaign', 'delete campaign', 'view campaign']);

        // create viewer role and assign permissions
        $role = Role::create(['name' => 'viewer'])
        	->givePermissionTo('view campaign');

        // create viewer role and assign permissions
        $role = Role::create(['name' => 'owner']);
        $role->givePermissionTo(Permission::all());

        // Assign admin owner
        $user = App\User::find(1);
        $user->assignRole('owner');

    }
}
