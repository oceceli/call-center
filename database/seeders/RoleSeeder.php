<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        foreach(Role::$untouchables as $roleName) {
            Role::create(['name' => $roleName]);
        }
        $role = Role::create(['name' => 'agent']);

        $role->givePermissionTo('view customers');
        $role->givePermissionTo('edit customers');
        $role->givePermissionTo('process customers');
    }
}
