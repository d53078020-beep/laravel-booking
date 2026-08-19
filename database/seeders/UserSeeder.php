<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminUser();
    }

    public function createAdminUser()
    {
        User::firstOrCreate(
            ['email' => 'admin2@mail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        )->roles()->sync(Role::where('name', RoleName::ADMIN->value)->first());
    }
}
