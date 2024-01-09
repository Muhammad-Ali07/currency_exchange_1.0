<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Validator;

class ChartOfAccountTreeController extends Controller
{

    private static function Constants()
    {
        $name = 'chart-of-account-tree';
        return [
            'title' => 'Chart of Account Tree',
            'list_url' => route('accounts.chart-of-account-tree.index'),
            'view' => "$name-view",
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['permission'] = self::Constants()['view'];



        return view('accounts.chart_of_account_tree.list', compact('data'));
    }
    public function getChartOfAccountTree(){

        $tree = [];
        $parents = ChartOfAccount::with('children')->where('level','1')->orderby('code')
            ->select('id','code','name')->get();

        foreach ($parents as $first){
            $secondLevelArr = [];
            foreach ($first['children'] as $secondItem){
                $thirdLevelArr = [];
                foreach ($secondItem['children'] as $thirdItem){
                    $forthLevelArr = [];
                    foreach ($thirdItem['children'] as $forthItem){
                        $forthLevel = [
                            "text" => "[".$forthItem->code."] ".self::strUCWord($forthItem->name),
                            "id" => $forthItem->code,
                            "main_id" => $forthItem->id,
                            "parent_main_id" => $thirdItem->id,
                            "level" => 4,
                        ];
                        array_push($forthLevelArr, $forthLevel);
                    }
                    $thirdLevel = [
                        "text" => "[".$thirdItem->code."] ".self::strUCWord($thirdItem->name),
                        "id" => $thirdItem->code,
                        "main_id" => $thirdItem->id,
                        "level" => 3,
                        "parent_main_id" => $secondItem->id,
                        "children" => $forthLevelArr
                    ];
                    array_push($thirdLevelArr, $thirdLevel);
                }
                $secondLevel = [
                    "text" => "[".$secondItem->code."] ".self::strUCWord($secondItem->name),
                    "id" => $secondItem->code,
                    "main_id" => $secondItem->id,
                    "level" => 2,
                    "parent_main_id" => $first->id,
                    "children" => $thirdLevelArr
                ];
                array_push($secondLevelArr, $secondLevel);
            }
            $firstLevel = [
                "text" => "[".$first->code."] ".self::strUCWord($first->name),
                "id" => $first->code,
                "main_id" => $first->id,
                "level" => 1,
                "children" => $secondLevelArr
            ];
            array_push($tree, $firstLevel);
        }

        $newTree = mb_convert_encoding($tree, "UTF-8", "auto");

        return response()->json($newTree);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $data['code'] = self::coaDisplayMaxCode(1,0);
        return view('accounts.chart_of_account.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'level' => 'required',
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
        }
        if(!isset($request->level) || empty($request->level)){
            return $this->jsonErrorResponse($data, 'Level is required');
        }
        if($request->level != 1 && empty($request->parent_account)){
            return $this->jsonErrorResponse($data, 'Parent account is required');
        }
        DB::beginTransaction();
        try {
            $code = self::coaDisplayMaxCode($request->level,$request->parent_account);

            if($request->level == 1){
                $parent_account_id = NULL;
                $parent_account_code = NULL;
            }else{
                $chart = ChartOfAccount::where('code',$request->parent_account)->first();
                if(empty($chart)){
                    return $this->jsonErrorResponse($data, 'Parent account not correct');
                }
                $parent_account_id = $chart->id;
                $parent_account_code = $request->parent_account;
            }

            ChartOfAccount::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'code' => $code,
                'level' => $request->level,
                'group' => ($request->level < 4)?'G':'D',
                'parent_account_id' => $parent_account_id,
                'parent_account_code' => $parent_account_code,
                'status' => isset($request->status) ? "1" : "0",
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        return $this->jsonSuccessResponse($data, 'Successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];
        if(ChartOfAccount::where('uuid',$id)->exists()){

            $data['current'] = ChartOfAccount::where('uuid',$id)->first();

        }else{
            abort('404');
        }

        return view('accounts.chart_of_account.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
        }

        DB::beginTransaction();
        try {

            ChartOfAccount::where('uuid',$id)
                ->update([
                    'name' => self::strUCWord($request->name),
                    'status' => isset($request->status) ? "1" : "0",
                    'company_id' => auth()->user()->company_id,
                    'project_id' => auth()->user()->project_id,
                    'user_id' => auth()->user()->id,
                ]);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

        $data['redirect'] = self::Constants()['list_url'];
        return $this->jsonSuccessResponse($data, 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = [];
        DB::beginTransaction();
        try{

            ChartOfAccount::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

    public function getParentCoaList(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        try{
            $level = (int)$request->level - 1;
            $data['charts'] = ChartOfAccount::where('level',$level)->get(['code','name']);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully loaded', 200);
    }

    public function getChildCodeByParentAccount(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        try{

            $data['code'] = self::coaDisplayMaxCode($request->level,$request->parent_account);

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully loaded', 200);
    }

    public static function coaDisplayMaxCode($radioValue,$parent_account_code)
    {
        $parent_account_code = empty($parent_account_code)?NULL:$parent_account_code;

        $code = ChartOfAccount::where('parent_account_code','=',$parent_account_code)->max('code');

        if(empty($code)){
            $code = empty($parent_account_code)?NULL:$parent_account_code;
        }

        $max_code = self::getMaxChartCode($radioValue,$code);

        return $max_code;

    }
    public static function getMaxChartCode($radioValue,$chart_code){
        if($radioValue == 1){
            if(empty($chart_code)){
                $max_code = '01-00-0000-0000';
            }else{
                $code = substr($chart_code,0,2);
                $max =  sprintf("%'02d", $code+1);
                $max_code = substr_replace($chart_code,$max,0,2);
                $max_code = $max.'-00-0000-0000';
            }
        }
        if($radioValue == 2){
            $code = substr($chart_code,3,2);
            $max =  sprintf("%'02d", (int)$code+1);
            $max_code = substr_replace($chart_code,$max,3,2);
        }
        if($radioValue == 3){
            $code = substr($chart_code,6,4);
            $max =  sprintf("%'04d", (int)$code+1);
            $max_code = substr_replace($chart_code,$max,6,4);
        }
        if($radioValue == 4){
            $code = substr($chart_code,11,4);
            $max =  sprintf("%'04d", (int)$code+1);
            $max_code = substr_replace($chart_code,$max,11,4);
        }
        return $max_code;
    }

}
