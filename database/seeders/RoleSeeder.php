<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        //Role admin
        $admin = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('admin123'),
        ]);

        if (!$admin->hasRole($adminRole)) {
            $admin->assignRole($adminRole);
        }

        //Role user
        $user = User::firstOrCreate([
            'email' => 'user@gmail.com',
        ], [
            'name' => 'User',
            'password' => bcrypt('user123'),
        ]);

        if (!$user->hasRole($userRole)) {
            $user->assignRole($userRole);
        }
    }
}

