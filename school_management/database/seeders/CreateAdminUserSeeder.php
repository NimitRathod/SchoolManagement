<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [[
            'name' => 'Developer -Nimit Rathod', 
            'email' => 'developer@gmail.com',
            'password' => bcrypt('developer@123'),
        ]];
        
        foreach($users AS $user_data){
            $user = User::create($user_data);
        }

        $user = User::where('email','developer@gmail.com')->first();

        $role = Role::where('name','developer')->first();
        
        $user->assignRole([$role->id]);

    }
}
