<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Accounts\ChartOfAccountController;
use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\ChartOfAccount;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Exception;
use Validator;

class SupplierController extends Controller
{
    private static function Constants()
    {
        $name = 'supplier';
        return [
            'title' => 'Supplier',
            'list_url' => route('master.supplier.index'),
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

            $dataSql = Supplier::where('id','<>',0)->where(Utilities::CompanyProjectId())->orderByName();

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
                $urlEdit = route('master.supplier.edit',$row->uuid);
                $urlDel = route('master.supplier.destroy',$row->uuid);

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
                    $row->contact_no,
                    $row->email,
                    '<div class="text-center"><span class="badge rounded-pill ' . $entry_status['class'] . '">' . $entry_status['title'] . '</span></div>',
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

        return view('sale.supplier.list', compact('data'));
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
            'model'             => 'Supplier',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('sp'),
            'form_type_field'        => 'form_type',
            'form_type_value'       => 'supplier',
        ];
        $data['code'] = Utilities::documentCode($doc_data);
        return view('sale.supplier.create', compact('data'));
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
            // 'cnic_no' => 'required',
            'email' => 'nullable|email',
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
        $doc_data = [
            'model'             => 'Supplier',
            'code_field'        => 'code',
            'code_prefix'       => strtoupper('sp'),
            'form_type_field'        => 'form_type',
            'form_type_value'       => 'supplier',
        ];
        $data['code'] = Utilities::documentCode($doc_data);
        // dd($request->all());
        DB::beginTransaction();
        try {
            // COA working
            $req = [
                'name' => $request->name,
                'level' => 4,
                'parent_account' => '02-01-0001-0000',
            ];
            $r = Utilities::createCOA($req);
            // dd($r);
            if(isset($r['status']) && $r['status'] == 'error'){
                return $this->jsonErrorResponse($data, $r['message']);
            }

            Supplier::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'code' => $data['code'],
                'contact_no' => $request->contact_no,
                'email' => $request->email,
                'status' => isset($request->status) ? "1" : "0",
                'form_type' => 'supplier',
                'address' => $request->address,
                'coa_id' => $r->coa_id,
                'coa_uuid' => $r->coa_uuid,
                'coa_code' => $r->coa_code,

                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'branch_id' => auth()->user()->branch_id,
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

        if(Supplier::where('uuid',$id)->exists()){

            $data['current'] = Supplier::where('uuid',$id)->where(Utilities::CompanyProjectId())->first();


        }else{
            abort('404');
        }

        // $data['view'] = false;
        // if(isset($request->view)){
        //     $data['view'] = true;
        //     $data['permission'] = self::Constants()['view'];
        //     $data['permission_edit'] = self::Constants()['edit'];
        // }
        return view('sale.supplier.edit', compact('data'));
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
            'email' => 'nullable|email',
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
        // dd($request->all());
        DB::beginTransaction();
        try {
            Supplier::where('uuid',$id)
                ->update([
                    'name' => self::strUCWord($request->name),
                    'contact_no' => $request->contact_no,
                    'email' => $request->email,
                    'status' => isset($request->status) ? "1" : "0",
                    'form_type' => 'supplier',
                    'address' => $request->address,

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

            Supplier::where('uuid',$id)->where(Utilities::CompanyProjectId())->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }
}
