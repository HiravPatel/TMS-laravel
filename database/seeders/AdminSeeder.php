<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ['name'=>'sabale pooja','email' => 'sabalepooja@gmail.com','password' => bcrypt('pooja'),'cno'=>910691783, 'role_id' => 1,'created_at' => now(), 'updated_at' => now(),'first_login'=>0],
        ]); 
    }
}
