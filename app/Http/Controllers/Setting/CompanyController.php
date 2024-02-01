<?php

namespace App\Http\Controllers\Setting;

use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Validator;

class CompanyController extends Controller
{

    private static function Constants()
    {
        $name = 'company';
        return [
            'title' => 'Company',
            'list_url' => route('setting.company.index'),
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
        $data['permission_list'] = self::Constants()['list'];
        $data['permission_create'] = self::Constants()['create'];
        $result_count = 0;

        if ($request->ajax()) {
            $draw = 'all';

            $allData = Company::first();
            // $dataSql = Company::where('id','<>',0)->orderByName();

            // $allData = $dataSql->get();

            // $recordsTotal = count($allData);
            // $recordsFiltered = count($allData);
            // dd($recordsFiltered);
            $delete_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['delete'])){
                $delete_per = true;
            }
            $edit_per = false;
            if(auth()->user()->isAbleTo(self::Constants()['edit'])){
                $edit_per = true;
            }

            $entries = [];
            // foreach ($allData as $allData) {
                $urlEdit = route('setting.company.edit',$allData->uuid);
                $urlDel = route('setting.company.destroy',$allData->uuid);

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
                    $allData->name,
                    $allData->contact_no,
                    // isset($allData->addresses->country->name)?$allData->addresses->country->name:"",
                    // $allData->address,
                    $allData->company_image,
                    $actions,
                ];
            // }
            $form = 'company';
            $result = [
                'draw' => $draw,
                'form' => $form,
                // 'recordsTotal' => $recordsTotal,
                // 'recordsFiltered' => $recordsFiltered,
                'data' => $entries,
            ];
            // $result_count = $recordsTotal;
            // dd($result);
            return response()->json($result);
        }

        // dd($result_count);
        // $data['result_count'] = $result_count;

        return view('setting.company.list', compact('data'));
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
        return view('setting.company.create', compact('data'));
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
            'company_image' => ['required',Rule::notIn([0,'0'])]
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
            // dump($request->all());
            $company_filename = '';
            // $om_filename = '';
            if ($request->has('company_image')) {
                $file = $request->file('company_image');
                $company_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
                $file->move(public_path('uploads'), $company_filename);
            }
            // dd($company_filename);
            $company = Company::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'company_image' => $company_filename,
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

        if(Company::where('uuid',$id)->exists()){

            $data['current'] = Company::where('uuid',$id)->first();

        }else{
            abort('404');
        }

        return view('setting.company.edit', compact('data'));
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
        // dd('in update');
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'country_id' => 'required'
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
            // dd($request->all());
            $company_filename = '';
            // $om_filename = '';
            if ($request->has('company_image')) {
                $file = $request->file('company_image');
                $company_filename = date('yzHis') . '-' . Auth::user()->id . '-' . sprintf("%'05d", rand(0, 99999)) . '.png';
                $file->move(public_path('uploads'), $company_filename);
            }
            // dd($request->all());
            Company::where('uuid',$id)
                ->update([
                    'name' => self::strUCWord($request->name),
                    'contact_no' => $request->contact_no,
                    'address' => $request->address,
                    'company_image' => $company_filename,
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

            Company::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

}
