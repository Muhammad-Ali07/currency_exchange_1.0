<?php

namespace App\Http\Controllers\Sale;

use App\Library\Utilities;
use App\Models\BookingFileStatus;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Project;
use App\Models\PropertyPaymentMode;
use App\Models\Sale;
use App\Models\SaleSeller;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\Rule;
use Validator;

class SaleInvoiceController extends Controller
{
    private static function Constants()
    {
        // $name = 'sale-invoice';
        $name = 'sale';

        return [
            'title' => 'Retail Transaction',
            // 'list_url' => route('sale.sale-invoice.index'),
            'list_url' => route('transaction.sale.index'),
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
        // dd('in index');
        $data = [];
        $data['title'] = self::Constants()['title'];

        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];

        if ($request->ajax()) {
            $draw = 'all';
            // dd('in if');

            $dataSql = Sale::with('customer','product')->where(Utilities::CompanyProjectId())->orderby('created_at','desc');

            $allData = $dataSql->get();
            // dd($allData);
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
                $urlEdit = route('transaction.sale.edit',$row->uuid);
                $urlDel = route('transaction.sale.destroy',$row->uuid);
                // $urlPrint = route('transaction.sale.print',$row->uuid);

                // $urlEdit = route('sale.sale-invoice.edit',$row->uuid);
                // $urlDel = route('sale.sale-invoice.destroy',$row->uuid);
                // $urlPrint = route('sale.sale-invoice.print',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per || $print_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    if($print_per) {
                        // $actions .= '<a href="' . $urlPrint . '" target="_blank" class="dropdown-item"><i data-feather="printer" class="me-50"></i>Print</a>';
                    }
                    if($delete_per) {
                        $actions .= '<a href="javascript:;" data-url="'.$urlDel.'" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    }
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per){
                    $actions .= '<a href="'.$urlEdit.'" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    date('d-m-Y',strtotime($row->created_at)),
                    $row->code,
                    '<div class="text-center">' . ucfirst($row->transaction_type) . '</div>',
                    $row->product->name,
                    $row->customer->name,
                    $row->sale_price,
                    $row->quantity,
                    // isset($row->property_payment_mode->name)?$row->property_payment_mode->name:"",
                    $actions,
                ];
            }
            $result = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $entries,
            ];
            // dd($result);
            return response()->json($result);
        }

        return view('sale.sale_invoice.list', compact('data'));
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
        $doc_data = [
            'model'             => 'Sale',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('si'),
        ];
        $data['code'] = Utilities::documentCode($doc_data);
        return view('sale.sale_invoice.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = [];
        $validator = Validator::make($request->all(), [
            'product_id' => ['required',Rule::notIn([0,'0'])],
            'customer_id' => ['required',Rule::notIn([0,'0'])],
            'sale_price' => ['required'],
            'quantity' => ['required'],
        ],[
            'product_id.required' => 'Product is required',
            'customer_id.required' => 'Customer is required',
            'sale_price.required' => 'Price is required',
            'quantity.required' => 'Quantity is required',
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
        try{
            $doc_data = [
                'model'             => 'Sale',
                'code_field'        => 'code',
                'code_prefix'       => strtoupper('si'),
            ];
            $code = Utilities::documentCode($doc_data);
            // dd($request->all());
            $customer = Customer::where('id',$request->customer_id)->first();
            $cst_account = ChartOfAccount::where('id',$customer->coa_id)->first();
            // dd($cst_account);
            $sale = Sale::create([
                'uuid' => self::uuid(),
                'code' => $code,
                'entry_date' => date('Y-m-d', strtotime($request->entry_date)),
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'transaction_type' => $request->transaction_type,
                'sale_price' => $request->sale_price,
                'quantity' => $request->quantity,
                'amount' => $request->amount,
                'description' => $request->remarks,

                'company_id' => auth()->user()->company_id,
                'branch_id' => auth()->user()->branch_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

            $product = Product::where('id',$request->product_id)->first();
            $balance_qty = $product->stock_in - $request->quantity;
            $product->stock_in = $balance_qty;
            $product->save();

            $max = Voucher::withTrashed()->where('type','SI')->max('voucher_no');
            $voucher_no = self::documentCode('SI',$max);
            $voucher_id = self::uuid();
            $posted = $request->current_action_id == 'post'?1:0;
            // dd($voucher_no);
            Voucher::create([
                'voucher_id' => $voucher_id,
                'uuid' => self::uuid(),
                'date' => date('Y-m-d', strtotime($request->entry_date)),
                'type' => 'SI',
                'voucher_no' => $voucher_no,
                'sr_no' => 1,
                'chart_account_id' => $cst_account->id,
                'chart_account_name' => $cst_account->name,
                'chart_account_code' => $cst_account->code,
                'debit' => Utilities::NumFormat($request->sale_price),
                'credit' => Utilities::NumFormat(0),
                'description' => 'dummy',
                'remarks' => 'dummy remarks',
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'branch_id' => auth()->user()->branch_id,
                'user_id' => auth()->user()->id,
                'posted' => 0,
            ]);
            // Voucher::create([
            //     'voucher_id' => $voucher_id,
            //     'uuid' => self::uuid(),
            //     'date' => date('Y-m-d', strtotime($request->date)),
            //     'type' => 'CPV',
            //     'voucher_no' => $voucher_no,
            //     'sr_no' => 1,
            //     'chart_account_id' => 182,
            //     'chart_account_name' => 'Pkr Sales',
            //     'chart_account_code' => '04-01-0001-0000',
            //     'debit' => Utilities::NumFormat(0),
            //     'credit' => Utilities::NumFormat($request->amount),
            //     'description' => 'dummy',
            //     'remarks' => 'dummy remarks',
            //     'company_id' => auth()->user()->company_id,
            //     'project_id' => auth()->user()->project_id,
            //     'branch_id' => auth()->user()->branch_id,
            //     'user_id' => auth()->user()->id,
            //     'posted' => 0,
            // ]);
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
        // dd('in edit func');
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];

        if(Sale::where('uuid',$id)->exists()){
            $data['current'] = Sale::where('uuid',$id)->where(Utilities::CompanyProjectId())->with('product','customer')->first();
        }else{
            abort('404');
        }
        // dd($data['current']);
        // $data['view'] = false;
        // if(isset($request->view)){
        //     $data['view'] = true;
        //     $data['permission'] = self::Constants()['view'];
        //     $data['permission_edit'] = self::Constants()['edit'];
        // }

        return view('sale.sale_invoice.edit', compact('data'));
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
            //'project_id' => ['required',Rule::notIn([0,'0'])],
            'product_id' => ['required',Rule::notIn([0,'0'])],
            'customer_id' => ['required',Rule::notIn([0,'0'])],
            'seller_type' => ['required',Rule::in(['dealer','staff'])],
            'seller_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            //'project_id.required' => 'Project is required',
            //'project_id.not_in' => 'Project is required',
            'product_id.required' => 'Product is required',
            'product_id.not_in' => 'Product is required',
            'customer_id.required' => 'Customer is required',
            'customer_id.not_in' => 'Customer is required',
            'seller_type.required' => 'Seller type is required',
            'seller_type.in' => 'Seller type is required',
            'seller_id.required' => 'Seller is required',
            'seller_id.not_in' => 'Seller is required',
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
        try{
            Sale::where('uuid',$id)
                ->update([
                'customer_id' => $request->customer_id,
                'sale_by_staff' => ($request->seller_type == 'staff')?1:0,
                'project_id' => auth()->user()->project_id,
                'product_id' => $request->product_id,
                'property_payment_mode_id' => $request->property_payment_mode_id,
                'is_installment' => isset($request->is_installment)?1:0,
                'is_booked' => isset($request->is_booked)?1:0,
                'is_purchased' => isset($request->is_purchased)?1:0,
                'sale_price' => $request->sale_price,
                'currency_note_no' => empty($request->currency_note_no)?0:$request->currency_note_no,
                'booked_price' => $request->booked_price,
                'down_payment' => $request->down_payment,
                'on_balloting' => $request->on_balloting,
                'no_of_bi_annual' => $request->no_of_bi_annual,
                'installment_bi_annual' => $request->installment_bi_annual,
                'no_of_month' => $request->no_of_month,
                'installment_amount_monthly' => $request->installment_amount_monthly,
                'on_possession' => $request->on_possession,
                'file_status_id' => $request->file_status_id,
                'sale_discount' => $request->sale_discount,
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->user()->id,
            ]);

            $sale = Sale::where('uuid',$id)->first();

            $saleSeller = new SaleSeller();
            $saleSeller->sale_sellerable_id = $request->seller_id;


            if($request->seller_type == 'staff'){
                $saleSeller->sale_sellerable_type = 'App\Models\Staff';
               // dd($saleSeller->toArray());
                $sale->dealer()->update($saleSeller->toArray());
            }
            if($request->seller_type == 'dealer'){
                $saleSeller->sale_sellerable_type = 'App\Models\Dealer';
                $sale->dealer()->update($saleSeller->toArray());
            }



        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();

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
        //
    }

    public function printView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['permission'] = self::Constants()['print'];

        if(Sale::where('uuid',$id)->exists()){

            $data['current'] = Sale::with('product','customer','dealer','staff','property_payment_mode','file_status')->where(Utilities::CompanyProjectId())->where('uuid',$id)->first();

        }else{
            abort('404');
        }
        return view('sale.sale_invoice.print', compact('data'));
    }

    public function getSellerList(Request $request)
    {

        $data = [];

        $seller_type = isset($request->seller_type)?$request->seller_type:"";
        $sellerList = ['dealer','staff'];
        if(!in_array($seller_type ,$sellerList)){
            return $this->jsonErrorResponse($data, "Seller type not correct", 200);
        }

        DB::beginTransaction();
        try{
            if($seller_type == 'dealer'){
                $data['seller'] = Dealer::where(Utilities::CompanyProjectId())->OrderByName()->get();
            }

            if($seller_type == 'staff'){
                $data['seller'] = Staff::where(Utilities::CompanyProjectId())->OrderByName()->get();
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get seller', 200);
    }
    public function getProductDetail(Request $request)
    {

        $data = [];

        $product_id = isset($request->product_id)?$request->product_id:"";

        DB::beginTransaction();
        try{
            $data['product'] = Product::where('id',$product_id)->first();

            if(empty($data['product'])){
                return $this->jsonErrorResponse($data, "Product not found", 200);
            }

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get product detail', 200);
    }
}
