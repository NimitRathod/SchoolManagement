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
            'name' => 'Nimit Rathod', 
            'email' => 'nimitrathod1997@gmail.com',
            'password' => bcrypt('nimit@123'),
        ]];
        
        foreach($users AS $user_data){
            $user = User::create($user_data);
        }

        $user = User::where('email','nimitrathod1997@gmail.com')->first();

        $role = Role::where('name','developer')->first();
        
        $user->assignRole([$role->id]);

    }
}
