<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends Controller
{

    private static function Constants()
    {
        $name = 'user';
        return [
            'title' => 'User',
            'list_url' => route('setting.user.index'),
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

            $dataSql = User::where('id','<>',0);

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
                $urlEdit = route('setting.user.edit',$row->uuid);
                $urlDel = route('setting.user.destroy',$row->uuid);

                $actions = '<div class="text-end">';
                if($delete_per) {
                    /*$actions .= '<div class="d-inline-flex">';
                    $actions .= '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown"><i data-feather="more-vertical"></i></a>';
                    $actions .= '<div class="dropdown-menu dropdown-menu-end">';
                    $actions .= '<a href="javascript:;" data-url="' . $urlDel . '" class="dropdown-item delete-record"><i data-feather="trash-2" class="me-50"></i>Delete</a>';
                    $actions .= '</div>'; // end dropdown-menu
                    $actions .= '</div>'; // end d-inline-flex*/
                }
                if($edit_per) {
                    $actions .= '<a href="' . $urlEdit . '" class="item-edit"><i data-feather="edit"></i></a>';
                }
                $actions .= '</div>'; //end main div

                $entries[] = [
                    $row->name,
                    $row->email,
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

        return view('setting.user.list', compact('data'));
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
        $data['branch'] = Branch::get();

        return view('setting.user.create', compact('data'));
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
            'email' => 'required|email|unique:users',
            'branch_id' => ['required',Rule::notIn([0,'0'])],
            'password' => ['required'],
            'confirm_password' => 'required|same:password'
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is required',
            'email.unique' => 'Email already used',
            'branch_id.required' => 'Branch is required',
            'branch_id.not_in' => 'Branch is required',
            'password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm Password is required',
            'confirm_password.same' => 'Confirm Password must be same as password',
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
            // dd($request->branch_id);
            $user = User::create([
                'uuid' => self::uuid(),
                'name' => self::strUCWord($request->name),
                'email' => $request->email,
                'user_status' => isset($request->status)?1:0,
                'password' => Hash::make($request->password),
                'company_id' => auth()->user()->company_id,
                'branch_id' => 1,
                'project_id' => 1,

            ]);
            // if(isset($request->projects)){
            //     $projects = $request->projects;
            // }else{
            //     $projects = [];
            // }

            // if(!in_array($request->project_id,$projects)){
            //     array_push($projects,$request->project_id);
            // }

            // $userProject = User::find($user->id);
            // $userProject->projects()->attach($projects);

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
        $data['branches'] = Branch::get();

        if(User::where('uuid',$id)->exists()){
            $data['current'] = User::with('branch')->where('uuid',$id)->first();
            //dd($data['current']->toArray());
        }else{
            abort('404');
        }
        $data['view'] = false;
        if(isset($request->view)){
            $data['view'] = true;
            $data['permission'] = self::Constants()['view'];
            $data['permission_edit'] = self::Constants()['edit'];
        }

        return view('setting.user.edit', compact('data'));
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
        // dd($request->all());
        $data = [];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
           // 'email' => 'required|email|unique:users',
            // 'branch_id' => ['required',Rule::notIn([0,'0'])],
//            'password' => ['required'],
//            'confirm_password' => 'required|same:password'
        ],[
            'name.required' => 'Name is required',
//            'email.required' => 'Email is required',
//            'email.email' => 'Email is required',
//            'email.unique' => 'Email already used',
            // 'branch.required' => 'Branch is required',
            // 'branch_id.not_in' => 'Branch is required',
//            'password.required' => 'Password is required',
//            'confirm_password.required' => 'Confirm Password is required',
//            'confirm_password.same' => 'Confirm Password must be same as password',
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
            $user = User::where('uuid',$id)->first();
            $user->name = self::strUCWord($request->name);
            $user->user_status = isset($request->status)?1:0;
            $user->company_id = auth()->user()->company_id;
            $user->branch_id = 1;
            $user->project_id = 1;
            $user->save();

            // if(isset($request->projects)){
            //     $projects = $request->projects;
            // }else{
            //     $projects = [];
            // }

            // if(!in_array($request->project_id,$projects)){
            //     array_push($projects,$request->project_id);
            // }

            // $userProject = User::find($user->id);
            // $userProject->projects()->sync($projects);

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

            User::where('uuid',$id)->delete();

        }catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();
        return $this->jsonSuccessResponse($data, 'Successfully deleted', 200);
    }

}
