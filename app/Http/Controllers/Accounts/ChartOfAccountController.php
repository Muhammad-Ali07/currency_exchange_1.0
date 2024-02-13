<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Validator;

class ChartOfAccountController extends Controller
{

    private static function Constants()
    {
        $name = 'chart-of-account';
        return [
            'title' => 'Chart of Account',
            'list_url' => route('accounts.chart-of-account.index'),
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
            'view' => "$name-view",
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
        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];
        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = ChartOfAccount::where('id','<>',0)->orderby('level');

            $allData = $dataSql->get();

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);

            $delete_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['delete'])){
                $delete_per = true;
            }
            $edit_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['edit'])){
                $edit_per = true;
            }
            $entries = [];
            foreach ($allData as $row) {
                $urlEdit = route('accounts.chart-of-account.edit',$row->uuid);
                $urlDel = route('accounts.chart-of-account.destroy',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->name,
                    $row->code,
                    $row->level,
                    $row->group,
                    $actions,
                ];
            }
            $result = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $entries,
            ];
            return response()->json($result);
        }

        return view('accounts.chart_of_account.list', compact('data'));
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
                    'product_id' => isset($request->product_id) ? $request->product_id : "",

                    'company_id' => auth()->user()->company_id,
                    'branch_id' => auth()->user()->branch_id,
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
    public function edit(Request $request,$id)
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

        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }
        $data['products'] = Product::get();
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
                    'product_id' => $request->to_product_id,
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
