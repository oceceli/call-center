<?php

namespace Database\Seeders;

use App\Models\Call;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'test','email' => 'test@test.com', 'password' => '$2a$12$FwCduObDSYCMq0wtkipfM.sOVKniWD2.vxpiuDPVGyaI//FnDxeKG', 'is_active' => '1']); // 444444444
        User::factory(50)->create();
        Customer::factory(200)->create();
        Call::factory(10)->create();

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);

    }
}
