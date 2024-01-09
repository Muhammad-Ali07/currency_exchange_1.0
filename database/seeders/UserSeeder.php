<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'=>'admin','email'=>'admin@gmail.com','pass'=>'gaga']
        ];
        $comp = Company::first();
        $project = Project::first();
        foreach($users as $user){
            if(!User::where('email',$user['email'])->exists()){
                User::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['pass']),
                    'user_status' => 1,
                    'company_id' => $comp->id,
                    'project_id' => $project->id,
                ]);
            }
        }
    }
}
