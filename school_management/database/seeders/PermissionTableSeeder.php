<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'no-permission',
            
            'panel-user-managment',

            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            
            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',
            
            'permissions-list',
            'permissions-create',
            'permissions-edit',
            'permissions-delete',
            
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
