<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rule;
use Webpatser\Uuid\Uuid;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonSuccessResponse( $data, $message, $statusCode = 200 )
    {
        return response()->json(['status'=>'success', 'data'=>(object)$data, 'message'=>$message], $statusCode);
    }

    protected function jsonErrorResponse( $data, $message,  $statusCode = 203)
    {
        return response()->json(['status'=>'error', 'data'=>(object)$data, 'message'=>$message], $statusCode);
    }

    protected function arrSuccessResponse($data, $message)
    {
        return ['status'=>'success', 'data'=>$data, 'message'=>$message];
    }

    protected function arrErrorResponse($data, $message)
    {
        return ['status'=>'error', 'data'=>$data, 'message'=>$message];
    }

    protected function getStatusTitle(){
        return [
            ['title'=> 'De Active', 'class' => 'badge-light-warning'],
            ['title'=> 'Active', 'class' => 'badge-light-success']
        ];
    }

    protected function getPostedTitle(){
        return [
            ['title'=> 'Draft', 'class' => 'badge-light-warning'],
            ['title'=> 'Posted', 'class' => 'badge-light-success']
        ];
    }
    protected function strUCWord($str){
        return ucwords(strtolower(strtoupper(trim($str))));
    }
    protected function uuid(){
        return Uuid::generate()->string;
    }

    public static function insertAddress($request,$modal){

        $validator = Validator::make($request->all(), [
            'country_id' => ['required',Rule::notIn([0,'0'])],
            'region_id' => ['required',Rule::notIn([0,'0'])],
            'city_id' => ['required',Rule::notIn([0,'0'])],
            'address' => ['required',Rule::notIn([0,'0'])],
        ],[
            'country_id.required' => 'Country is required',
            'country_id.not_in' => 'Country is required',
            'region_id.required' => 'Region is required',
            'region_id.not_in' => 'Region is required',
            'city_id.required' => 'City is required',
            'city_id.not_in' => 'City is required',
            'address.required' => 'Address is required',
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return ['status'=>'error', 'message'=>$err];
        }

        $address = new Address();
        $address->country_id = $request->country_id;
        $address->region_id = $request->region_id;
        $address->city_id = $request->city_id;
        $address->address = $request->address;

        if(empty($modal->addresses)){
            $modal->addresses()->save($address);
        }else{
            $modal->addresses()->update($address->toArray());
        }
    }

    public static function documentCode($type,$max){
        if(empty($type)){
            return 0;
        }
        $num = sprintf("%'05d", 0);
        $prefix = strtoupper($type);
        $currentYear = date('y');
        $codeYear = $currentYear;
        if(!empty($max)){
            $max = explode('-',$max);
            $max = end($max);
            $codeYear = substr($max,0,2);
            $num = (int)$max + 1;
        }
        if($codeYear != $currentYear || empty($max)){
            $max = 1;
            $max = sprintf("%'05d", $max);
            $num = $currentYear.$max;
        }
        return $prefix.'-'.$num;
    }
}
