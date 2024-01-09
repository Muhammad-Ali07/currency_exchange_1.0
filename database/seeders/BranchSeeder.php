<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Branch;
use App\Models\City;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $list = [
            ['name'=>'Branch - 1','contact_no'=>'32100765400']
        ];
        $comp = Company::first();
        foreach($list as $row){
            if(!Branch::where('name',$row['name'])->exists()){
                $branch = Branch::create([
                    'uuid' =>  Uuid::generate()->string,
                    'name' => $row['name'],
                    'contact_no' => $row['contact_no'],
                    'company_id' => $comp->id,
                ]);

                $city = City::where('name','Lahore')->first();
                $address = new Address();
                $address->country_id = $city->country_id;
                $address->region_id = $city->region_id;
                $address->city_id = $city->id;
                $address->address = '';
                $branch->addresses()->save($address);
            }
        }
    }
}
