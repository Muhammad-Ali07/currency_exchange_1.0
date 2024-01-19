<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\Brand;
use App\Models\BuyableType;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductQuantity;
use App\Models\ProductVariation;
use App\Models\ProductVariationDtl;
use App\Models\Project;
use App\Models\PropertyVariation;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;

class ProductPropertyController extends Controller
{
    private static function Constants()
    {
        $name = 'product-quantity';
        return [
            'title' => 'Product Quantity',
            'list_url' => route('master.product-quantity.index'),
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
        // dd('in index');
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];
        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = ProductQuantity::where(Utilities::CompanyProjectId());

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
                // $entry_status = $this->getStatusTitle()[$row->status];
                $urlEdit = route('master.product-quantity.edit',$row->uuid);
                $urlDel = route('master.product-quantity.destroy',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per) {
                    $actions .= '<div class="d-inline-flex">';
                    // $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    // $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    // $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    // $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->code,
                    $row->name,
                    $row->transaction_type,
                    $row->quantity,
                    $row->sale_price,
                    // '<div class="text-center"><span class="badge rounded-pill ' . $entry_status['class'] . '">' . $entry_status['title'] . '</span></div>',
                    $actions,
                ];
            }
            // dd($entries);
            $result = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $entries,
            ];
            return response()->json($result);
        }

        return view('sale.product_quantity.list', compact('data'));
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
        $doc_data = [
            'model'             => 'ProductQuantity',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('pq'),
            'form_type_field'        => 'form_type',
            'form_type_value'       => 'product_quantity',
        ];
        $data['code'] = Utilities::documentCode($doc_data);
        return view('sale.product_quantity.create', compact('data'));
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
            'product_name' => 'required',
            'product_quantity' => 'required',
            'buying_rate' => 'required',
        ],[
            'product_name.required' => 'Name is required',
            'product_quantity.required' => 'Quantity is required',
            'buying_rate.required' => 'Buying rate is required',
        ]);
        // dd($request->all());

        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            $validator_errors = $data['validator_errors']->getMessageBag()->toArray();
            $err = 'Fields are required';
            foreach ($validator_errors as $key=>$valid_error){
                $err = $valid_error[0];
            }
            return $this->jsonErrorResponse($data, $err);
        }
        // dd($request->all());
        DB::beginTransaction();
        try {
            $doc_data = [
                'model'             => 'ProductQuantity',
                'code_field'        => 'code',
                'code_prefix'       => strtoupper('pq'),
                'form_type_field'        => 'form_type',
                'form_type_value'       => 'product_quantity',
            ];
            $data['code'] = Utilities::documentCode($doc_data);
            // dd($request->product_id);
            $product = Product::where('id',$request->product_id)->where(Utilities::CompanyProjectId())->first();

            // dd($product);
            $p_data = [
                'uuid' => self::uuid(),
                'entry_date' => date('Y-m-d', strtotime($request->entry_date)),
                'name' => self::strUCWord($request->product_name),
                'code' => $data['code'],
                'form_type' => 'product_quantity',
                'product_id' => $request->product_id,
                'supplier_id' => $request->supplier_id,
                'quantity' => $request->product_quantity,
                'buying_rate' => $request->buying_rate,

                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'branch_id' => auth()->user()->branch_id,
                'user_id' => auth()->user()->id,
            ];
            $product = Product::where('id',$request->product_id)->where(Utilities::CompanyProjectId())->first();
            $total_qty = $request->product_quantity + $product->stock_in;
            $product->stock_in = $total_qty;
            $product->save();

            ProductQuantity::create($p_data);
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

        if(ProductQuantity::where('uuid',$id)->exists()){

            $data['current'] = ProductQuantity::with('product')->where(Utilities::CompanyProjectId())->where('uuid',$id)->first();
        }else{
            abort('404');
        }

        return view('sale.product_quantity.edit', compact('data'));
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_quantity' => 'required',
            'buying_rate' => 'required',
        ],[
           'product_name.required' => 'Name is required',
           'product_quantity.required' => 'Project is required',
           'buying_rate.required' => 'Buying rate is required',
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
            $p_data = [
                'name' => self::strUCWord($request->product_name),
                'product_id' => $request->product_id,
                'quantity' => $request->product_quantity,
                'buying_rate' => $request->buying_rate,

                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'branch_id' => auth()->user()->branch_id,
                'user_id' => auth()->user()->id,
            ];

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
        dd('in delete');
        $data = [];
        DB::beginTransaction();
        try{

            Product::where('uuid',$id)->where(Utilities::CompanyProjectId())->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }
}
