<?php

namespace Database\Seeders;

use App\Models\Role;
use Spatie\Permission\Models\Permission;
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
        foreach(Role::getAvailablePerms() as $perm)
        {
            Permission::create(['name' => $perm['value']]);
        }
    }
}
