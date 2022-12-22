<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Developer',
            ],
            [
                'id' => 2,
                'name' => 'Administrator',
            ],
            [
                'id' => 3,
                'name' => 'Mahasiswa',
            ],
            [
                'id' => 4,
                'name' => 'Dosen',
            ],
            [
                'id' => 5,
                'name' => 'Pegawai',
            ],
        ]);
    }
}
