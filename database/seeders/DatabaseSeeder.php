<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */


    public function run(): void
    {

        // User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            HotelSeeder::class,
            HotelRoomSeeder::class
        ]);


        // $user = User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('password'),
        // ]);

        // $adminRole = Role::where('name', RoleName::ADMIN->value)->first();

        // $user->roles()->attach($adminRole);

        // $hotelOwner = User::factory()->create([
        //     'name' => 'Hotel Owner',
        //     'email' => 'owner@mail.com',
        //     'password' => bcrypt('password'),
        // ]);

        // $ownerRole = Role::where('name', RoleName::HOTEL_OWNER->value)->first();
        // $hotelOwner->roles()->attach($ownerRole);

        // $adminRole = Role::where('name', RoleName::ADMIN->value)->first();
        // $user->roles()->attach($adminRole);
    }
}
