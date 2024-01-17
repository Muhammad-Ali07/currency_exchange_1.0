<?php
namespace App\Library;

use App\Http\Controllers\Accounts\ChartOfAccountController;
use App\Models\ChartOfAccount;
use App\Models\Project;
use Webpatser\Uuid\Uuid;

class Utilities
{
    public static function CompanyId(){
        return ['company_id'=>auth()->user()->company_id];
    }

    public static function CompanyProjectId(){
        return [
            'company_id'=>auth()->user()->company_id,
            'project_id'=>auth()->user()->project_id,
            // 'branch_id'=>auth()->user()->branch_id,
        ];
    }
    public static function CurrentBC(){
        return [
            'company_id'=>auth()->user()->company_id,
            'branch_id'=>auth()->user()->branch_id,
        ];
    }
    public static function documentCode($doc_data){
        $model = $doc_data['model'];
        $code_field = $doc_data['code_field'];
        $code_prefix = $doc_data['code_prefix'];
        $form_type_field = isset($doc_data['form_type_field'])?$doc_data['form_type_field']:"";
        $form_type_value = isset($doc_data['form_type_value'])?$doc_data['form_type_value']:"";

        $modelN = 'App\Models\\'.$model;
        if(!empty($form_type_field) && !empty($form_type_value)){
            $max = $modelN::where($form_type_field,$form_type_value)->max($code_field);
        }else{
            $max = $modelN::max($code_field);
        }

        // max = "SP-0000000", type = "SP"
        if(!empty($max)){
            $max = explode('-',$max);
            $max = end($max);
            $max = $max+1;
        }else{
            $max = 1;
        }
        $new_code =  sprintf("%'05d", $max); // return 12 to 0000012
        $code = strtoupper($code_prefix)."-".$new_code; // return "SP-0000012"
        return $code; // return "SP-0000012"
    }

    public static function createCOA($req){

        $parent_account = $req['parent_account'];
        $level = $req['level'];
        $name = $req['name'];

        $parent_account_dtl = ChartOfAccount::where('code',$parent_account)->first();

        if(!empty($parent_account_dtl)){
            $code = ChartOfAccountController::coaDisplayMaxCode($level,$parent_account);
            try{
                ChartOfAccount::create([
                    'uuid' => Uuid::generate()->string,
                    'name' => ucwords(strtolower(strtoupper(trim($name)))),
                    'code' => $code,
                    'level' => $level,
                    'group' => ($level < 4)?'G':'D',
                    'parent_account_id' => $parent_account_dtl->id,
                    'parent_account_code' => $parent_account,
                    'status' => 1,
                    'company_id' => auth()->user()->company_id,
                    'project_id' => auth()->user()->project_id,
                    'user_id' => auth()->user()->id,
                ]);
            }catch (\Exception $e){
                return ['status'=>'error', 'message'=>'Chart of Account not created.'];
            }
        }else{
            return ['status'=>'error', 'message'=>'Parent Code not Found.'];
        }

    }

    public static function NumFormat($num){
        return number_format($num,3,'.','');
    }

    public static function getAllBranches(){
        $branches = Project::where('user_id',auth()->user()->id)->get();
        return $branches;
    }
}
