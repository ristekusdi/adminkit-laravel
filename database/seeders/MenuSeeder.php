<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'id' => 1,
                'text' => 'Menus',
                'path' => 'menus',
                'icon' => 'menu',
                'parent' => '0',
                'order' => '0'  
            ],
            [
                'id' => 2,
                'text' => 'RBAC',
                'path' => '#',
                'icon' => null,
                'parent' => '0',
                'order' => '0'
            ],
            [
                'id' => 3,
                'text' => 'Permissions',
                'path' => 'rbac/permissions',
                'icon' => null,
                'parent' => '2',
                'order' => '0'
            ],
            [
                'id' => 4,
                'text' => 'Roles',
                'path' => 'rbac/roles',
                'icon' => null,
                'parent' => '2',
                'order' => '0'
            ],
            [
                'id' => 5,
                'text' => 'Users',
                'path' => 'rbac/users',
                'icon' => null,
                'parent' => '2',
                'order' => '0'
            ],
            [
                'id' => 6,
                'text' => 'Login as',
                'path' => 'loginas',
                'icon' => null,
                'parent' => '0',
                'order' => '0'
            ],
        ]);
    }
}
