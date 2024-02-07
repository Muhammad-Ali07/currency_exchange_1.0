<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\ChartOfAccount;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\Voucher;
use App\Models\VoucherUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class CashReceiveController extends Controller
{
    private static function Constants()
    {
        $name = 'cash-receive';
        return [
            'type' => "CRV",
            'title' => 'Cash Receive',
            'list_url' => route('accounts.cash-receive.index'),
            'list' => "$name-list",
            'create' => "$name-create",
            'edit' => "$name-edit",
            'delete' => "$name-delete",
            'view' => "$name-view",
            'print' => "$name-print",
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

            $dataSql = Voucher::where('type',self::Constants()['type'])->distinct()->orderby('date','desc');

            $allData = $dataSql->get(['voucher_id','voucher_no','date','posted','remarks']);

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
            $print_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['print'])){
                $print_per = true;
            }
            $entries = [];
            foreach ($allData as $row) {
                $posted = $this->getPostedTitle()[$row->posted];
                $urlEdit = route('accounts.cash-receive.edit',$row->voucher_id);
                $urlDel = route('accounts.cash-receive.destroy',$row->voucher_id);
                $urlPrint = route('accounts.cash-receive.print',$row->voucher_id);

                $actions = '<div class="text-end">';
                if($delete_per || $print_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    if($print_per) {
                        $actions .= '<a href="' . $urlPrint . '" target="_blank" class="dropdown-item"><i data-feather="printer" class="me-50"></i>Print</a>';
                    }
                    if($delete_per) {
                        $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    }
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->date,
                    $row->voucher_no,
                    '<div class="text-center"><span class="badge rounded-pill ' . $posted['class'] . '">' . $posted['title'] . '</span></div>',
                    $row->remarks,
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

        return view('accounts.cash_receive.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $max = Voucher::withTrashed()->where('type',self::Constants()['type'])->max('voucher_no');
        $data['voucher_no'] = self::documentCode(self::Constants()['type'],$max);

        return view('accounts.cash_receive.create', compact('data'));
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
        if(!isset($request->pd) || empty($request->pd)){
            return $this->jsonErrorResponse($data, 'Grid must be include one row');
        }

        $total_debit = 0;
        $total_credit = 0;
        foreach ($request->pd as $pd) {
            $total_debit += $pd['egt_debit'];
            $total_credit += $pd['egt_credit'];
        }
        if(($total_debit != $total_credit) || (empty($total_debit) && empty($total_credit)) ){
            return $this->jsonErrorResponse($data, 'debit credit must be equal');
        }

        DB::beginTransaction();
        try {
            // dd($request->all());
            $om_filename = '';
            $vu_id = '';
            if ($request->has('om_image')) {

                $file = $request->file('om_image');
                $om_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
                $file->move(public_path('uploads'), $om_filename);
                // dd($om_filename);
                $vu = VoucherUpload::create([
                    'uuid' => self::uuid(),
                    'name' => $om_filename,
                    'slug' => $om_filename,
                    'company_id' => auth()->user()->company_id,
                    'branch_id' => auth()->user()->branch_id,
                    'project_id' => auth()->user()->project_id,
                    'user_id' => auth()->user()->id,
                ]);
                // dd($vu);
                $vu_id = $vu->id;
            }else{
                $vu_id = '';
            }
            $max = Voucher::withTrashed()->where('type',self::Constants()['type'])->max('voucher_no');
            $voucher_no = self::documentCode(self::Constants()['type'],$max);
            $voucher_id = self::uuid();

            $posted = $request->current_action_id == 'post'?1:0;
            $sr = 1;
            foreach ($request->pd as $pd){
                $account = ChartOfAccount::where('id',$pd['chart_id'])->first();
                if(!empty($account)){

                    $balance_amount = $pd['egt_amount'] * $pd['egt_rate'] ;
                    Voucher::create([
                        'voucher_id' => $voucher_id,
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'type' => self::Constants()['type'],
                        'voucher_no' => $voucher_no,
                        'sr_no' => $sr,
                        'chart_account_id' => $account->id,
                        'chart_account_name' => $account->name,
                        'chart_account_code' => $account->code,
                        'amount' => $pd['egt_amount'],
                        'rate_per_unit' => $pd['egt_rate'],
                        'voucher_upload_id' => $vu_id,
                        'debit' => Utilities::NumFormat($pd['egt_debit']),
                        'credit' => Utilities::NumFormat($pd['egt_credit']),
                        'balance_amount' => Utilities::NumFormat($balance_amount),
                        'description' => $pd['egt_description'],
                        'remarks' => $request->remarks,
                        'company_id' => auth()->user()->company_id,
                        'branch_id' => auth()->user()->branch_id,
                        'project_id' => auth()->user()->project_id,
                        'user_id' => auth()->user()->id,
                        'posted' => $posted,
                    ]);
                    $sr = $sr + 1;
                    if(!empty($account->product_id)){
                        $product = Product::where('id',$account->product_id)->first();
                        $balance_stock = $product->stock_in;
                        $total_stock = $balance_stock + $pd['egt_amount'];
                        $product->stock_in = $total_stock;
                        $product->save();

                        $doc_data = [
                            'model'             => 'ProductQuantity',
                            'code_field'        => 'code',
                            'code_prefix'       => strtoupper('pq'),
                            'form_type_field'        => 'form_type',
                            'form_type_value'       => 'product_quantity',
                        ];
                        $code = Utilities::documentCode($doc_data);
                        $product_quantity = ProductQuantity::create([
                            'uuid' => self::uuid(),
                            'entry_date' => date('Y-m-d', strtotime($request->date)),
                            'name' => self::strUCWord($account->name),
                            'code' => $code,
                            'form_type' => 'product_quantity',
                            'product_id' => $product->id,
                            'quantity' => $pd['egt_amount'],
                            'balance_quantity' => $pd['egt_amount'],
                            'buying_rate' => $pd['egt_rate'],
                            'coa_id' => $account->id,
                            'coa_name' => $account->name,
                            'coa_code' => $account->code,
                            'coa_uuid' => $account->uuid,

                            'company_id' => auth()->user()->company_id,
                            'branch_id' => auth()->user()->branch_id,
                            'project_id' => auth()->user()->project_id,
                            'user_id' => auth()->user()->id,

                        ]);
                    }
                }
            }
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

        if(Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->exists()){

            $data['current'] = Voucher::where('type',self::Constants()['type'])->where(['voucher_id'=>$id,'sr_no'=>1])->with('voucher_uploads')->first();
            $data['dtl'] = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->with('voucher_uploads')->get();

        }else{
            abort('404');
        }
        $data['view'] = false;
        $data['posted'] = false;
        if($data['current']->posted == 1){
            $data['posted'] = true;
        }
        if(isset($request->view) || $data['current']->posted == 1){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }


        return view('accounts.cash_receive.edit', compact('data'));
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
        if(!isset($request->pd) || empty($request->pd)){
            return $this->jsonErrorResponse($data, 'Grid must be include one row');
        }


        $total_debit = 0;
        $total_credit = 0;
        foreach ($request->pd as $pd) {
            $total_debit += $pd['egt_debit'];
            $total_credit += $pd['egt_credit'];
        }
        if(($total_debit != $total_credit) || (empty($total_debit) && empty($total_credit)) ){
            return $this->jsonErrorResponse($data, 'debit credit must be equal');
        }

        DB::beginTransaction();
        try {

            $firstVoucher = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->first();
            if($firstVoucher->posted == 1){
                return $this->jsonErrorResponse($data, 'This voucher have been already posted');
            }
            $voucher_no = $firstVoucher->voucher_no;
            $voucher_id = $id;
            DB::select("delete FROM `vouchers` where voucher_id = '$voucher_id'");

            $om_filename = '';
            $vu_id = '';
            if ($request->has('om_image')) {
                $file = $request->file('om_image');
                $om_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
                $file->move(public_path('uploads'), $om_filename);

                $vu = VoucherUpload::create([
                    'uuid' => self::uuid(),
                    'name' => $om_filename,
                    'slug' => $om_filename,
                    'company_id' => auth()->user()->company_id,
                    'branch_id' => auth()->user()->branch_id,
                    'project_id' => auth()->user()->project_id,
                    'user_id' => auth()->user()->id,
                ]);
                $vu_id = $vu->id;
            }
            else{
                if( ($request->om_image == 'null' || $request->om_image == "") && ($request->om_hidden_image == '' || $request->om_hidden_image == 'null')){
                    $om_filename = '';
                    $vu_id = 0;
                }else{
                    $om_filename = $request->om_hidden_image;
                    $vu_id = $request->om_hidden_image_upload_id;
                }
            }
            $vu = VoucherUpload::where('id',$request->om_hidden_image_upload_id)
                ->update([
                'name' => $om_filename,
                'slug' => $om_filename,
                'company_id' => auth()->user()->company_id,
                'branch_id' => auth()->user()->branch_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);


            $posted = $request->current_action_id == 'post'?1:0;
            $sr = 1;
            foreach ($request->pd as $pd){
                $account = ChartOfAccount::where('id',$pd['chart_id'])->first();
                if(!empty($account)){
                    Voucher::create([
                        'voucher_id' => $voucher_id,
                        'uuid' => self::uuid(),
                        'date' => date('Y-m-d', strtotime($request->date)),
                        'type' => self::Constants()['type'],
                        'voucher_no' => $voucher_no,
                        'sr_no' => $sr,
                        'chart_account_id' => $account->id,
                        'chart_account_name' => $account->name,
                        'chart_account_code' => $account->code,
                        'debit' => Utilities::NumFormat($pd['egt_debit']),
                        'credit' => Utilities::NumFormat($pd['egt_credit']),
                        'description' => $pd['egt_description'],
                        'remarks' => $request->remarks,
                        'voucher_upload_id' => $vu_id,
                        'company_id' => auth()->user()->company_id,
                        'project_id' => auth()->user()->project_id,
                        'user_id' => auth()->user()->id,
                        'posted' => $posted,
                    ]);
                    $sr = $sr + 1;
                }
            }

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

            Voucher::where('voucher_id',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }


    public function printView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['permission'] = self::Constants()['print'];

        if(Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->exists()){

            $data['current'] = Voucher::where('type',self::Constants()['type'])->where(['voucher_id'=>$id,'sr_no'=>1])->first();
            $data['dtl'] = Voucher::where('type',self::Constants()['type'])->where('voucher_id',$id)->get();

        }else{
            abort('404');
        }

        return view('accounts.cash_receive.print', compact('data'));
    }

    public function revertList(Request $request)
    {
        $data = [];
        $data['title'] = self::Constants()['title'];

        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = Voucher::where('type',self::Constants()['type'])->onlyTrashed()->distinct()->orderby('date','desc');

            $allData = $dataSql->get(['voucher_id','voucher_no','date','posted','remarks']);

            $recordsTotal = count($allData);
            $recordsFiltered = count($allData);

            $entries = [];
            foreach ($allData as $row) {
                $posted = $this->getPostedTitle()[$row->posted];
                $urlRevert = route('accounts.cash-receive.revert',$row->voucher_id);

                $actions = '<div class="text-end">';
                $actions .= '<a href="javascript:;" data-url="' . $urlRevert . '" class="revert-record">Revert</a>';
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->date,
                    $row->voucher_no,
                    '<div class="text-center"><span class="badge rounded-pill ' . $posted['class'] . '">' . $posted['title'] . '</span></div>',
                    $row->remarks,
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

        return view('accounts.cash_receive.revert_list', compact('data'));
    }

    public function revert($id){
        $data = [];
        DB::beginTransaction();
        try{

            Voucher::where('voucher_id',$id)->onlyTrashed()->restore();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully revert', 200);
    }
}
