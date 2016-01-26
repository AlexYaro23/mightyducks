<?php

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
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
        $this->call(UserTableSeeder::class);
        $this->call(TeamTableSeeder::class);
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


class UserTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::create(['provider_id' => '5360839', 'screen_name' => 'id5360839', 'name' => 'Alex']);
        $user->roles()->attach(1);
    }
}

class TeamTableSeeder extends Seeder
{
    public function run()
    {
        Team::create([
            'mls_id' => '182',
            'name' => 'MightyDucks',
            'link' => 'http://mls.od.ua/component/joomsport/team/70/182'
        ]);
    }
}

class TournamenttableSeeder extends Seeder
{
    public function run()
    {
        Tournament::create([
            'id' => '1',
            'name' => 'Friendly'
        ]);
    }
}