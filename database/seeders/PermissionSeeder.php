<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    Permission::insert([
        ['name' => 'view_users', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'edit_users', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'delete_users', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'add_projects', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'view_dashboard', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'add_users', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'edit_projects', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'delete_projects', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'view_projects', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'view_tasks', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'add_tasks', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'edit_tasks', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'delete_tasks', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'view_bugs', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'add_bug', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'edit_bug', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'delete_bug', 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}
