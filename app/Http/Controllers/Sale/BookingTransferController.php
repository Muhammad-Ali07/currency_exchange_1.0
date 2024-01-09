<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\BookingFileStatus;
use App\Models\BookingTransfer;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PropertyPaymentMode;
use App\Models\Sale;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingTransferController extends Controller
{
    private static function Constants()
    {
        $name = 'booking-transfer';
        return [
            'title' => 'Booking Transfer',
            'list_url' => route('sale.booking-transfer.index'),
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
        //
        $data = [];
        $data['title'] = self::Constants()['title'];

        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];

        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = BookingTransfer::where(Utilities::CompanyProjectId())->orderby('created_at','desc');
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
            $print_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['print'])){
                $print_per = true;
            }
            // dd($edit_per);
            $entries = [];
            foreach ($allData as $row) {
                $urlEdit = route('sale.booking-transfer.edit',$row->uuid);
                $urlDel = route('sale.booking-transfer.destroy',$row->uuid);
                $urlPrint = route('sale.booking-transfer.print',$row->uuid);
                // dd(route('sale.booking-transfer.edit'));
                $actions = '<div class="text-end">';
                if($delete_per || $print_per) {
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    if($print_per) {
                        $actions .= '<a href="' . $urlPrint . '" target="_blank" class="dropdown-item"><i data-feather="printer" class="me-50"></i>Print</a>';
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
                // dd($actions);
                $entries[] = [
                    date('d-m-Y',strtotime($row->date)),
                    $row->code,
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

    return view('sale.booking_transfer.list', compact('data'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['create'];
        $doc_data = [
            'model'             => 'BookingTransfer',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('tsi'),
        ];
        $data['code'] = Utilities::documentCode($doc_data);

        return view('sale.booking_transfer.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd('in store controller ! ');
        $data = [];
        $validator = Validator::make($request->all(), [
            'date' => ['required'],
            'nm_customer_id' => ['required'],
            'om_customer_id' => ['required'],
            'product_id' => ['required'],
            'booking_id' => ['required'],
        ],[
            'date.required' => 'Date is required',
            'nm_customer_id.required' => 'New Member is required',
            'om_customer_id.required' => 'Seller is required',
            'product_id.required' => 'Product Name is required',
            'booking_id.required' => 'Booking is required',
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
                'model'             => 'BookingTransfer',
                'code_field'        => 'code',
                'code_prefix'       => strtoupper('tsi'),
            ];
            $code = Utilities::documentCode($doc_data);

            $nm_filename = '';
            $om_filename = '';
            if ($request->has('nm_image')) {
                $file = $request->file('nm_image');
                $nm_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
                $file->move(public_path('uploads'), $nm_filename);
            }
            if ($request->has('om_image')) {
                $file = $request->file('om_image');
                $om_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
                $file->move(public_path('uploads'), $om_filename);
            }
            $booking_transfer = BookingTransfer::create([
                'uuid' => self::uuid(),
                'code' => $code,
                'date' => date('Y-m-d', strtotime($request->date)),
                'nm_customer_id' => $request->nm_customer_id,
                'nm_customer_name' => $request->nm_customer_name,
                'nm_membership_no' => $request->nm_membership_no,
                'nm_registration_no' => $request->nm_registration_no,
                'nm_mobile_no' => $request->nm_mobile_no,
                'nm_cnic_no' => $request->nm_cnic_no,
                'nm_image' => $nm_filename,

                'nm_nominee_no' => $request->nm_nominee_no,
                'nm_nominee_name' => $request->nm_nominee_name,
                'nm_nominee_parent_name' => $request->nm_nominee_parent_name,
                'nm_nominee_cnic_no' => $request->nm_nominee_cnic_no,
                'nm_nominee_contact_no' => $request->nm_nominee_contact_no,
                'nm_nominee_relation' => $request->nm_nominee_relation,

                'om_customer_id' => $request->om_customer_id,
                'om_customer_name' => $request->om_customer_name,
                'om_membership_no' => $request->om_membership_no,
                'om_cnic_no' => $request->om_cnic_no,
                'om_registration_no' => $request->om_registration_no,
                'om_mobile_no' => $request->om_mobile_no,
                'booking_id' => $request->booking_id,
                'booking_code' => $request->booking_code,

                'om_image' => $om_filename,

                'om_nominee_no' => $request->om_nominee_no,
                'om_nominee_name' => $request->om_nominee_name,
                'om_nominee_parent_name' => $request->om_nominee_parent_name,
                'om_nominee_cnic_no' => $request->om_nominee_cnic_no,
                'om_nominee_contact_no' => $request->om_nominee_contact_no,
                'om_nominee_relation' => $request->om_nominee_relation,
                'file_status_id' => $request->file_status_id,

                'product_id' => $request->product_id,
                'product_name' => $request->product_name,
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
    public function edit(Request $request,$id)
    {
        //
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];
        if(BookingTransfer::where('uuid',$id)->exists()){
            $data['current'] = BookingTransfer::where('uuid',$id)->where(Utilities::CompanyProjectId())->with('nm_customer','om_customer','file_status')->first();
        }else{
            abort('404');
        }
        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }

        return view('sale.booking_transfer.edit', compact('data'));

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
        // dd($request->toArray());
        $data = [];
        $validator = Validator::make($request->all(), [
            'date' => ['required'],
            'nm_customer_id' => ['required'],
            'om_customer_id' => ['required'],
            'product_id' => ['required'],
            'booking_id' => ['required'],
        ],[
            'date.required' => 'Date is required',
            'nm_customer_id.required' => 'New Member is required',
            'om_customer_id.required' => 'Seller is required',
            'product_id.required' => 'Product Name is required',
            'booking_id.required' => 'Booking is required',
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
        $nm_filename = '';
        $om_filename = '';
        if ($request->has('nm_image')) {
            $file = $request->file('nm_image');
            $nm_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
            $file->move(public_path('uploads'), $nm_filename);
        }else{
            if(($request->nm_image == 'null' || $request->nm_image == "") && ($request->nm_hidden_image == '' || $request->nm_hidden_image == 'null')  ){
                $nm_filename = '';
                // dd($request->nm_image);
            }else{
                $nm_filename = $request->nm_hidden_image;
                // dd('not null');
            }
        }
        if ($request->has('om_image')) {
            $file = $request->file('om_image');
            $om_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
            $file->move(public_path('uploads'), $om_filename);
        }
        else{
            if( ($request->om_image == 'null' || $request->om_image == "") && ($request->om_hidden_image == '' || $request->om_hidden_image == 'null')){
                $om_filename = '';
            }else{
                $om_filename = $request->om_hidden_image;
            }

        }
        DB::beginTransaction();
        try {
            BookingTransfer::where('uuid',$id)
                ->update([
                    'date' => date('Y-m-d', strtotime($request->date)),
                    'nm_customer_id' => $request->nm_customer_id,
                    'nm_customer_name' => $request->nm_customer_name,
                    'nm_membership_no' => $request->nm_membership_no,
                    'nm_registration_no' => $request->nm_registration_no,
                    'nm_mobile_no' => $request->nm_mobile_no,
                    'nm_cnic_no' => $request->nm_cnic_no,
                    'nm_image' => $nm_filename,

                    'nm_nominee_no' => $request->nm_nominee_no,
                    'nm_nominee_name' => $request->nm_nominee_name,
                    'nm_nominee_parent_name' => $request->nm_nominee_parent_name,
                    'nm_nominee_cnic_no' => $request->nm_nominee_cnic_no,
                    'nm_nominee_contact_no' => $request->nm_nominee_contact_no,
                    'nm_nominee_relation' => $request->nm_nominee_relation,

                    'om_customer_id' => $request->om_customer_id,
                    'om_customer_name' => $request->om_customer_name,
                    'om_membership_no' => $request->om_membership_no,
                    'om_cnic_no' => $request->om_cnic_no,
                    'om_registration_no' => $request->om_registration_no,
                    'om_mobile_no' => $request->om_mobile_no,
                    'booking_id' => $request->booking_id,
                    'booking_code' => $request->booking_code,

                    'om_image' => $om_filename,

                    'om_nominee_no' => $request->om_nominee_no,
                    'om_nominee_name' => $request->om_nominee_name,
                    'om_nominee_parent_name' => $request->om_nominee_parent_name,
                    'om_nominee_cnic_no' => $request->om_nominee_cnic_no,
                    'om_nominee_contact_no' => $request->om_nominee_contact_no,
                    'om_nominee_relation' => $request->om_nominee_relation,
                    'file_status_id' => $request->file_status_id,

                    'product_id' => $request->product_id,
                    'product_name' => $request->product_name,
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

    public function getCustomerList(Request $request)
    {

        $data = [];
        $customer_id = isset($request->customer_id)?$request->customer_id:"";

        DB::beginTransaction();
        try{
            $data['customer'] = Customer::where('id',$customer_id)->where(Utilities::CompanyProjectId())->with('sales')->first();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get Customer', 200);
    }

    public function getBookingDtl(Request $request)
    {
        $data = [];
        $sale_id = isset($request->sale_id)?$request->sale_id:"";
        DB::beginTransaction();
        try{
            $data['sales'] = Sale::where('id',$sale_id)->with('file_status','property_payment_mode','product')->first();
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully get Customer', 200);
    }

    public function printView($id)
    {
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['permission'] = self::Constants()['print'];

        if(BookingTransfer::where('uuid',$id)->exists()){

            $data['current'] = BookingTransfer::with('nm_customer','om_customer','file_status','product')->where(Utilities::CompanyProjectId())->where('uuid',$id)->first();
        }else{
            abort('404');
        }
        return view('sale.booking_transfer.print', compact('data'));
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
        $data = [];
        DB::beginTransaction();
        try{
            BookingTransfer::where('uuid',$id)->delete();
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);

    }
}
