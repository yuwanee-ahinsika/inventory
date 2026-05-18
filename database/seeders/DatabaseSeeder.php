<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Inventory Manager']);
        $hodRole = Role::create(['name' => 'HOD']);
        $userRole = Role::create(['name' => 'Department User']);

        $itDept = Department::create(['name' => 'IT Department']);
        $hrDept = Department::create(['name' => 'HR Department']);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'department_id' => $itDept->id,
        ]);

        User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
            'department_id' => $itDept->id,
        ]);

        $hodUser = User::create([
            'name' => 'HR HOD',
            'email' => 'hod@example.com',
            'password' => Hash::make('password'),
            'role_id' => $hodRole->id,
            'department_id' => $hrDept->id,
        ]);

        User::create([
            'name' => 'HR User',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'department_id' => $hrDept->id,
            'hod_id' => $hodUser->id,
        ]);
    }
}
