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
                'text' => 'RBAC',
                'path' => '#',
                'parent' => '0',
                'order' => '0'
            ],
            [
                'id' => 2,
                'text' => 'Users',
                'path' => 'rbac/users',
                'parent' => '1',
                'order' => '0'
            ],
            [
                'id' => 3,
                'text' => 'Roles',
                'path' => 'rbac/roles',
                'parent' => '1',
                'order' => '0'
            ],
            [
                'id' => 4,
                'text' => 'Permissions',
                'path' => 'rbac/permissions',
                'parent' => '1',
                'order' => '0'
            ],
            [
                'id' => 5,
                'text' => 'Login as',
                'path' => 'loginas',
                'parent' => '0',
                'order' => '0'
            ],
        ]);
    }
}
