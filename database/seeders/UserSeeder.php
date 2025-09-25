<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);

        $permissions = [
            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',
            'force_delete_role',
            'force_delete_any_role',
            'restore_role',
            'restore_any_role',
            'replicate_role',
            'reorder_role',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            $roleAdmin->givePermissionTo($permission);
        }

        // User Ali
        $ali = User::create([
            'code'           => 'EMP0001',
            'username'       => 'alilatukau',
            'state'          => 'Active',
            'first_name'     => 'Ali',
            'last_name'      => 'Latukau',
            'employee_name'  => 'Ali Latukau',
            'user_type'      => 'Standard User',
            'image'          => null,
            'email'          => 'alilatukau@enesers.com',
            'email_verified_at' => now(),
            'password'       => Hash::make('alilatukau'),
            'remember_token' => Str::random(10),
        ]);

        // User Husien
        $husien = User::create([
            'code'           => 'EMP0002',
            'username'       => 'husien',
            'state'          => 'Active',
            'first_name'     => 'Husien',
            'last_name'      => 'Habib',
            'employee_name'  => 'Husien Habib',
            'user_type'      => 'Standard User',
            'image'          => null,
            'email'          => 'husien@enesers.com',
            'email_verified_at' => now(),
            'password'       => Hash::make('husien'),
            'remember_token' => Str::random(10),
        ]);

        // Assign role ke keduanya
        $ali->assignRole($roleAdmin);
        $husien->assignRole($roleAdmin);
    }
}
