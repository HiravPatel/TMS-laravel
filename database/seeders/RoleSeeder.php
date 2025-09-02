<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Role::insert([
            ['role' => 'Superadmin', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'Tester', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'Frontend Developer', 'created_at' => now(), 'updated_at' => now()],
            ['role' => 'Backened Developer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
