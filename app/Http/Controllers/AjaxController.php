<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //

    public function getCode($form_type){
        if($form_type == 'sell'){
            $doc_data = [
                'model'             => 'Sale',
                'transaction_type'  => 'sale',
                'code_field'        => 'code',

                'code_prefix'       => strtoupper('si'),
            ];
            $data['code'] = Utilities::documentCode($doc_data);
        }else{
            $doc_data = [
                'model'             => 'Sale',
                'transaction_type'  => 'purchase',
                'code_field'        => 'code',
                'code_prefix'       => strtoupper('pi'),
            ];
            $data['code'] = Utilities::documentCode($doc_data);
            dd($data['code']);
        }
    }
}
