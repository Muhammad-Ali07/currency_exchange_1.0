<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Validator;

class DealerController extends Controller
{

    private static function Constants()
    {
        $name = 'dealer';
        return [
            'title' => 'Dealer',
            'list_url' => route('sale.dealer.index'),
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

            $dataSql = Dealer::where('id','<>',0)->where(Utilities::CompanyProjectId())->orderByName();

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
                $urlEdit = route('sale.dealer.edit',$row->uuid);
                $urlDel = route('sale.dealer.destroy',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per){
                    $actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    $actions .= '<a href="javascript:;" data-url="'.$urlDel.'" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex
                }
                if($edit_per){
                    $actions .= '<a href="'.$urlEdit.'" class="item-edit"><i data-feather="edit"></i></a>';
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

        return view('sale.dealer.list', compact('data'));
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

        return view('sale.dealer.create', compact('data'));
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
            'cnic_no' => 'required',
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

        DB::beginTransaction();
        try {

            $dealer = Dealer::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'cnic_no' => $request->cnic_no,
                'contact_no' => $request->contact_no,
                'email' => $request->email,
                'commission' => $request->commission,
                'status' => isset($request->status) ? "1" : "0",
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

            $r = self::insertAddress($request,$dealer);

            if(isset($r['status']) && $r['status'] == 'error'){
                return $this->jsonErrorResponse($data, $r['message']);
            }

            $req = [
                'name' => $request->name,
                'level' => 4,
                'parent_account' => '03-03-0001-0000',
            ];
            $r = Utilities::createCOA($req);

            if(isset($r['status']) && $r['status'] == 'error'){
                return $this->jsonErrorResponse($data, $r['message']);
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
        if(Dealer::where('uuid',$id)->exists()){

            $data['current'] = Dealer::where('uuid',$id)->first();

        }else{
            abort('404');
        }
        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }

        return view('sale.dealer.edit', compact('data'));
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
            'cnic_no' => 'required',
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

        DB::beginTransaction();
        try {
            Dealer::where('uuid',$id)
                ->update([
                'name' => self::strUCWord($request->name),
                'cnic_no' => $request->cnic_no,
                'contact_no' => $request->contact_no,
                'email' => $request->email,
                'commission' => $request->commission,
                'status' => isset($request->status) ? "1" : "0",
                'company_id' => auth()->user()->company_id,
                'project_id' => auth()->user()->project_id,
                'user_id' => auth()->user()->id,
            ]);

            $dealer = Dealer::where('uuid',$id)->first();

            $r = self::insertAddress($request,$dealer);

            if(isset($r['status']) && $r['status'] == 'error'){
                return $this->jsonErrorResponse($data, $r['message']);
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

            Dealer::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }
}
