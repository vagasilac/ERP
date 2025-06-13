<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesPermissionsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Management']);
        Role::create(['name' => 'Financiar']);
        Role::create(['name' => 'Director Tehnic']);
        Role::create(['name' => 'Director Productie']);
        Role::create(['name' => 'Tehnolog']);
        Role::create(['name' => 'IWE']);
        Role::create(['name' => 'CTC']);
        Role::create(['name' => 'Aprovizionare']);
        Role::create(['name' => 'Magazioner']);
        Role::create(['name' => 'HR']);
        Role::create(['name' => 'Responsabil Transport']);

        foreach (User::all() as $user) {
            $user->assignRole(rand(1, 11));
        }
    }
}
