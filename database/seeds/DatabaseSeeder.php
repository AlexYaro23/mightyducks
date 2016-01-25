<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
    }
}


class RoleTableSeeder extends Seeder
{
    public function run()
    {
        Role::create(['id' => '1', 'name' => 'admin', 'description' => 'Admin']);
        Role::create(['id' => '2', 'name' => 'player', 'description' => 'Player']);
        Role::create(['id' => '3', 'name' => 'user', 'description' => 'User']);
    }
}


//class UserTableSeeder extends Seeder
//{
//    public function run()
//    {
//        User::create(['provider_id' => '']);
//    }
//}