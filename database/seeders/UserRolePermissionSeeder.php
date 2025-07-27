<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => RoleEnum::ADMIN->value]);
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->assignRole(RoleEnum::ADMIN->value);

        $customerRole = Role::firstOrCreate(['name' => RoleEnum::CUSTOMER->value]);
        $customerUser = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $customerUser->assignRole(RoleEnum::CUSTOMER->value);

        $guestRole = Role::firstOrCreate(['name' => RoleEnum::GUEST->value]);
        $tenantRole = Role::firstOrCreate(['name' => RoleEnum::TENANT->value]);
    }
}
