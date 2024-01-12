<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private static function Constants()
    {
        $name = 'product';
        return [
            'title' => 'Product',
            'list_url' => route('master.product.index'),
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
        //
        $data = [];
        $data['title'] = self::Constants()['title'];
        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];
        if ($request->ajax()) {
            $draw = 'all';

            $dataSql = Product::where('product_form_type','property')->where(Utilities::CurrentBC())->orderByName();
            // dd('done');
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
                $entry_status = $this->getStatusTitle()[$row->status];
                $urlEdit = route('master.product.edit',$row->uuid);
                $urlDel = route('master.product.destroy',$row->uuid);

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
                    $row->code,
                    $row->name,
                    // '<div class="text-center"><span class="badge rounded-pill ' . $entry_status['class'] . '">' . $entry_status['title'] . '</span></div>',
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

        return view('sale.product.list', compact('data'));
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
            'model'             => 'Product',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('pp'),
            'form_type_field'        => 'product_form_type',
            'form_type_value'       => 'currency',
        ];
        $data['code'] = Utilities::documentCode($doc_data);
        $data['product_types'] = ['Currency','Ticket'];

        // dd($data['product_types']);
        // $data['project'] = Project::where(Utilities::CompanyId())->OrderByName()->get();
        // $data['buyable'] = BuyableType::OrderByName()->where(Utilities::CompanyProjectId())->get();

        return view('sale.product.create', compact('data'));
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
         //   'project_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'product_name.required' => 'Name is required',
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
            $doc_data = [
                'model'             => 'Product',
                'code_field'        => 'code',
                'code_prefix'       => strtoupper('pp'),
                'form_type_field'        => 'product_form_type',
                'form_type_value'       => 'currency',
            ];
            $data['code'] = Utilities::documentCode($doc_data);
            $filename = '';
            // dd($request->all());
            // dd($request->product_image);
            if ($request->has('product_image')) {
                $file = $request->file('product_image');
                $filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
                // dd($filename);
                $file->move(public_path('uploads'), $filename);
            }
            $p_data = [
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->product_name),
                'code' => $data['code'],
                'product_form_type' => 'currency',
                'status' => isset($request->status) ? "1" : "0",
                // 'external_item_id' => $request->external_item_id,
                // 'default_sale_price' => $request->default_sale_price,
                'branch_id' => auth()->user()->branch_id,
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->user()->id,
            ];

            // if(isset($request->buyable_type_id) && !empty($request->buyable_type_id)){
            //     $p_data['buyable_type_id'] = $request->buyable_type_id;
            // }else{
            //     $p_data['buyable_type_id'] = NULL;
            // }
            $product = Product::create($p_data);


            // if(isset($request->pv) && !empty($request->pv)){
            //     foreach ($request->pv as $pvId=>$pvVal){
            //         if(is_array($pvVal)){
            //             $k = 1;
            //             foreach ($pvVal as $checkboxList){
            //                 if(!empty($checkboxList)){
            //                     PropertyVariation::create([
            //                         'sr_no' => $k,
            //                         'product_id' => $product->id,
            //                         'product_variation_id' => $pvId,
            //                         'value' => $checkboxList,
            //                         'company_id' => auth()->user()->company_id,
            //                         'project_id' => auth()->user()->project_id,
            //                         'user_id' => auth()->user()->id,
            //                     ]);
            //                     $k = $k + 1;
            //                 }
            //             }
            //         }else{
            //             if(!empty($pvVal)){
            //                 PropertyVariation::create([
            //                     'sr_no' => 1,
            //                     'product_id' => $product->id,
            //                     'product_variation_id' => $pvId,
            //                     'value' => $pvVal,
            //                     'company_id' => auth()->user()->company_id,
            //                     'project_id' => auth()->user()->project_id,
            //                     'user_id' => auth()->user()->id,
            //                 ]);
            //             }
            //         }
            //     }
            // }
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
        //
        $data = [];
        $data['id'] = $id;
        $data['title'] = self::Constants()['title'];
        $data['list_url'] = self::Constants()['list_url'];
        $data['permission'] = self::Constants()['edit'];
        $data['product_types'] = ['Currency','Ticket'];

        if(Product::where('uuid',$id)->exists()){

            $data['current'] = Product::where('uuid',$id)->first();

        }else{
            abort('404');
        }

        return view('sale.product.edit', compact('data'));
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
        //
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
            Product::where('uuid',$id)->where(Utilities::CurrentBC())->delete();
        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }
}
