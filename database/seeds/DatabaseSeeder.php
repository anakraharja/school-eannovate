<?php

use App\Admin;
use App\ClassRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@example.test',
            'password' => Hash::make(123456),
        ]);

        ClassRoom::create([
            'name' => 'Class One',
            'major' => 'Sistem Operasi',
            'created_by' => '1',
            'modified_by' => '1',
        ]);
        ClassRoom::create([
            'name' => 'Class Two',
            'major' => 'Arsitektur Komputer',
            'created_by' => '1',
            'modified_by' => '1',
        ]);
        ClassRoom::create([
            'name' => 'Class Three',
            'major' => 'Basis Data',
            'created_by' => '1',
            'modified_by' => '1',
        ]);
        ClassRoom::create([
            'name' => 'Class Four',
            'major' => 'Pemrograman Web',
            'created_by' => '1',
            'modified_by' => '1',
        ]);
    }
}
