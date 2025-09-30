<?php

namespace Database\Seeders;

use App\Models\RoleMapping;
use Illuminate\Database\Seeder;

class RolemappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoleMapping::insert([
        ['role_id' => 1,'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 3,'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 3,'permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 13, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 14, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 3,'permission_id' => 14, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 15, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 16, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 17, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 18, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 18, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 3,'permission_id' => 18, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 19, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 3,'permission_id' => 19, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 20, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 3,'permission_id' => 20, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 2,'permission_id' => 21, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 3,'permission_id' => 21, 'created_at' => now(), 'updated_at' => now()],
        ['role_id' => 1,'permission_id' => 22, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
