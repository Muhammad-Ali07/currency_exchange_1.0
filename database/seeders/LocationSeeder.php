<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'name' => 'Pakistan',
                'childes' => [
                    [
                        'name' => 'Punjab',
                        'childes' => [
                            [
                                'name' => 'Lahore'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        foreach($countries as $row){
            if(!Country::where('name',$row['name'])->exists()){
                $country = Country::create([
                    'uuid' => Uuid::generate()->string,
                    'name' =>  ucwords(strtolower(strtoupper($row['name']))),
                    'status' => 1,
                ]);
                foreach($row['childes'] as $rchild){
                    if(!Region::where('name',$rchild['name'])->exists()){
                        $region = Region::create([
                            'uuid' => Uuid::generate()->string,
                            'name' =>  ucwords(strtolower(strtoupper($rchild['name']))),
                            'country_id' => $country->id,
                        ]);
                        foreach($rchild['childes'] as $cchild){
                            if(!City::where('name',$cchild['name'])->exists()){
                                City::create([
                                    'uuid' => Uuid::generate()->string,
                                    'name' =>  ucwords(strtolower(strtoupper($cchild['name']))),
                                    'country_id' => $country->id,
                                    'region_id' => $region->id,
                                ]);
                            }
                        }
                    }
                }
            }
        }


    }
}
