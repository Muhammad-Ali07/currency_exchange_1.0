<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'=>'KSD','contact_no'=>'32100765400']
        ];
        foreach($users as $user){
            if(!Company::where('name',$user['name'])->exists()){
                $company = Company::create([
                    'uuid' =>  Uuid::generate()->string,
                    'name' => $user['name'],
                    'contact_no' => $user['contact_no'],
                ]);

                $city = City::where('name','Lahore')->first();
                $address = new Address();
                $address->country_id = $city->country_id;
                $address->region_id = $city->region_id;
                $address->city_id = $city->id;
                $address->address = '';
                $company->addresses()->save($address);
            }
        }
    }
}
