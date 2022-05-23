<?php

namespace Database\Seeders;

use App\Models\Call;
use App\Models\Customer;
use App\Models\Role;
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
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);

        $su = User::create(['name' => 'Super User','email' => 'superuser@example.com', 'password' => '$2a$12$EQwbO8M0fsBxYNc79kGqOO2AenpOyNJj8dRx/TGRy1PrvlmBh4fzm', 'is_active' => '1']); // dH$7qRQCam)3gT=w
        $suRole = Role::where('name', 'super admin')->first();
        $su->roles()->save($suRole);


        // admin oluşturulacak
        $user = User::create(['name' => 'test','email' => 'test@test.com', 'password' => '$2a$12$FwCduObDSYCMq0wtkipfM.sOVKniWD2.vxpiuDPVGyaI//FnDxeKG', 'is_active' => '1']); // 444444444
        $adminRole = Role::where('name', 'admin')->first();
        $user->roles()->save($adminRole);


        // dev mode
        User::factory(50)->create();
        Customer::factory(200)->create();
        Call::factory(10)->create();
    }
}
