<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'menus.index',
                'menu_id' => '1',
                'group' => 'Menus'
            ],
            [
                'id' => 2,
                'name' => 'menus.create',
                'menu_id' => '1',
                'group' => 'Menus'
            ],
            [
                'id' => 3,
                'name' => 'menus.edit',
                'menu_id' => '1',
                'group' => 'Menus'
            ],
            [
                'id' => 4,
                'name' => 'menus.delete',
                'menu_id' => '1',
                'group' => 'Menus'
            ],
            [
                'id' => 5,
                'name' => 'rbac.users.index',
                'menu_id' => '3',
                'group' => 'RBAC Users'
            ],
            [
                'id' => 6,
                'name' => 'rbac.users.create',
                'menu_id' => '3',
                'group' => 'RBAC Users'
            ],
            [
                'id' => 7,
                'name' => 'rbac.users.edit',
                'menu_id' => '3',
                'group' => 'RBAC Users'
            ],
            [
                'id' => 8,
                'name' => 'rbac.users.delete',
                'menu_id' => '3',
                'group' => 'RBAC Users'
            ],
            [
                'id' => 9,
                'name' => 'rbac.roles.index',
                'menu_id' => '4',
                'group' => 'RBAC Roles'
            ],
            [
                'id' => 10,
                'name' => 'rbac.roles.create',
                'menu_id' => '4',
                'group' => 'RBAC Roles'
            ],
            [
                'id' => 11,
                'name' => 'rbac.roles.edit',
                'menu_id' => '4',
                'group' => 'RBAC Roles'
            ],
            [
                'id' => 12,
                'name' => 'rbac.roles.delete',
                'menu_id' => '4',
                'group' => 'RBAC Roles'
            ],
            [
                'id' => 13,
                'name' => 'rbac.permissions.index',
                'menu_id' => '5',
                'group' => 'RBAC Permissions'
            ],
            [
                'id' => 14,
                'name' => 'rbac.permissions.create',
                'menu_id' => '5',
                'group' => 'RBAC Permissions'
            ],
            [
                'id' => 15,
                'name' => 'rbac.permissions.edit',
                'menu_id' => '5',
                'group' => 'RBAC Permissions'
            ],
            [
                'id' => 16,
                'name' => 'rbac.permissions.delete',
                'menu_id' => '5',
                'group' => 'RBAC Permissions'
            ],
            [
                'id' => 17,
                'name' => 'loginas',
                'menu_id' => '6',
                'group' => 'Login as'
            ],
        ]);
    }
}
