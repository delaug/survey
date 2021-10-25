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
        Role::create(['name' => 'Admin', 'description' => 'Provides admin access.']);
        Role::create(['name' => 'User', 'description' => 'Provides user access.']);
    }
}
