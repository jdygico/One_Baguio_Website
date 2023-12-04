<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
            'role list',
            'role create',
            'role edit',
            'role delete',
            'user list',
            'user create',
            'user edit',
            'user delete',

            'book list',
            'book view',
            'book create',
            'book edit',
            'book delete',
            'book status',

            'consult view',
            'consult edit',

            'patient list',
            'patient create',
            'patient edit',
            'patient delete',
            'patient view',

            'facility list',
            'facility create',
            'facility edit',
            'facility delete',
         ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role1 = Role::create(['name' => 'admin']);
        foreach ($permissions as $permission) {
            $role1->givePermissionTo($permission);
        }

        $role2 = Role::create(['name' => 'user']);
        $role2->givePermissionTo('book create');
        $role2->givePermissionTo('book edit');
        $role2->givePermissionTo('book delete');
        $role2->givePermissionTo('patient create');
        $role2->givePermissionTo('patient edit');
        $role2->givePermissionTo('patient delete');

        $role3 = Role::create(['name' => 'doctor']);
        $role3->givePermissionTo('book list');
        $role3->givePermissionTo('book view');
        $role3->givePermissionTo('book status');
        $role3->givePermissionTo('consult view');
        $role3->givePermissionTo('consult edit');
        $role3->givePermissionTo('facility list');
        $role3->givePermissionTo('patient list');
        $role3->givePermissionTo('patient view');
        
        $role4 = Role::create(['name' => 'receiving staff']);
        $role4->givePermissionTo('book list');
        $role4->givePermissionTo('book view');
        $role4->givePermissionTo('book status');
        $role4->givePermissionTo('facility list');    
        $role3->givePermissionTo('consult view');
    }
}
