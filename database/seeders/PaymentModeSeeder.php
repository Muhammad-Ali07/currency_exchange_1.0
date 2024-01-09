<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\PaymentMode;
use App\Models\PropertyPaymentMode;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_payment_modes = [
            ['name'=>'Cash','default'=>1],
            ['name'=>'Bank','default'=>0],
        ];
        $comp = Company::first();
        $project = Project::first();
        $user = User::first();
        foreach ($data_payment_modes as $payment_mode){
            if(!PaymentMode::where('name',$payment_mode['name'])->exists()){
                PaymentMode::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => $payment_mode['name'],
                    'default' => $payment_mode['default'],
                    'status' => 1,
                    'company_id' => $comp->id,
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                ]);
            }
        }
        /* Payment Mode for Property*/
        $property_payment_modes = [
            ['name'=>'Cash', 'old_name'=>'On Cash','slug'=>'cash','default'=>1],
            ['name'=>'Installment', 'old_name'=> 'On Installment','slug'=>'installment','default'=>0],
        ];
        foreach ($property_payment_modes as $row){
            if(!PropertyPaymentMode::where('name',$row['name'])->exists()
                && !PropertyPaymentMode::where('name',$row['old_name'])->exists()){

                PropertyPaymentMode::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => $row['name'],
                    'default' => $row['default'],
                    'slug' => $row['slug'],
                    'status' => 1,
                    'company_id' => $comp->id,
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                ]);
            }else{
                $ppm = PropertyPaymentMode::where('name',$row['old_name'])->first();
                if(!empty($ppm)){
                    $ppm->name = $row['name'];
                    $ppm->save();
                }
            }
        }
    }
}
