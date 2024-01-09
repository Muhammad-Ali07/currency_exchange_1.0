<?php

namespace Database\Seeders;

use App\Models\BookingFileStatus;
use App\Models\Company;
use App\Models\PaymentMode;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class BookingFileStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_file_status = [
            ['name'=>'Active','slug'=>'active','default'=>1],
            ['name'=>'Block','slug'=>'block','default'=>0],
            ['name'=>'Cancelled','slug'=>'cancelled','default'=>0],
            ['name'=>'Refunded','slug'=>'refunded','default'=>0],
            ['name'=>'Merged','slug'=>'merged','default'=>0],
            ['name'=>'Buyback','slug'=>'buyback','default'=>0],
            ['name'=>'Defaulted','slug'=>'defaulted','default'=>0],
        ];
        $comp = Company::first();
        $project = Project::first();
        $user = User::first();
        foreach ($data_file_status as $row){
            if(!BookingFileStatus::where('name',$row['name'])->exists()){
                BookingFileStatus::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => $row['name'],
                    'slug' => $row['slug'],
                    'default' => $row['default'],
                    'status' => 1,
                    'company_id' => $comp->id,
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
