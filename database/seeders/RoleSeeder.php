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
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        //Role admin
        $admin = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        $admin->assignRole($adminRole);

        //Role user
        $user = User::firstOrCreate([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user123'),
        ]);

        $user->assignRole($userRole);
    }
}
