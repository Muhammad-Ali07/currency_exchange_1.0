<?php

namespace App\Http\Controllers;

use App\Library\Utilities;
use App\Models\Branch;
use App\Models\BuyableType;
use App\Models\Project;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        dd('testing');
        $data['permission'] = 'home-view';
        $date = Carbon::now()->subDays(7);

        $data['today_sale'] = Sale::where('created_at', '>=', Carbon::today())->sum('sale_price');
        $data['today_sale'] = $data['today_sale']/1000;

        $data['last_week_sale'] = Sale::where('created_at', '>=', $date)->sum('sale_price');
        $data['last_week_sale'] = $data['last_week_sale']/1000;

        $data['current_week_sale'] = Sale::whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('sale_price');
        $data['current_week_sale'] = $data['current_week_sale']/1000;

        $data['last_month_sale'] = Sale::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('sale_price');
        $data['last_month_sale'] = $data['last_month_sale']/1000;

        // $data['items'] = Sale::select(
        //     DB::raw("(COUNT(*)) as count"),
        //     DB::raw("(sum(sale_price)) as price"),
        //     DB::raw("MONTHNAME(created_at) as month_name"),
        // )
        // ->whereYear('created_at', date('Y'))
        // ->orderBy('created_at','ASC')
        // ->groupBy('month_name')
        // ->get()
        // ->toArray();
        // $data['expense'] = [-200000, -400000];
        // dd($data['expense']);

            // $data['buyable_types'] = BuyableType::where(Utilities::CompanyId())->get();
            $data['buyable_types'] = [
                'Commercial Plots',
                'Plots',
                'House',
                'Apartments'
            ];
            $data['products_sold'] = ['7','2','3','3'];
            $data['products_remaining'] = ['1','0','1','1'];
            $data['receiables'] = ['100k','500k','200k','100k'];
            $data['categories'] = ['January', 'Feburary', 'March', 'April', 'May', 'June', 'July', 'August', 'September','October','November','December'];
            $data['earnings'] = [95, 177, 284, 256, 105, 63, 168, 218, 72, 166,133,122];
            $data['expense'] = [-145, -80, -60, -180, -100, -60, -85, -75, -100,-10,-20,-30];
            return view('home',compact('data'));
    }

    public function projectList(Request $request)
    {
        // for projects
        // $data = User::with('projects')->where('id',auth()->user()->id)->first();
        $data = [];
        $data['user'] = User::with('branch')->where('id',auth()->user()->id)->first();
        // dd($data);
        if(!session()->has('branch')){
            if($data['user']->branch != ''){
                $data['branches'] =  Branch::get();

                return view('auth.branch_list',compact('data'));

                // return redirect()->route('home');
            }else{
                $data['branches'] =  Branch::get();
                // dd($data);
                return view('auth.branch_list',compact('data'));
            }
        }else{

            return redirect()->route('home');
        }

        // for projects
        // if(!session()->has('user_project')){
        //     return view('auth.project_list',compact('data'));
        // }else{
        //     return redirect()->route('home');
        // }

    }
    public function defaultBranchStore(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'branch_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'branch_id.required' => 'Branch is required',
            'branch_id.not_in' => 'Branch is required',
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

            $user = User::with('branch')->where('id',auth()->user()->id)->first();
            $checkExistsBranch = false;
            // dd($user->branch);
            if(!empty($user->branch)){
                // foreach ($user->branch as $project){
                    if($user->branch->id == $request->branch_id){
                        $checkExistsBranch = true;
                    }
                // }
            }
            if($checkExistsBranch){
                $user->branch_id = $request->branch_id;
                $user->save();

                session(['user_branch' => $request->branch_id]);

            }else{
                return $this->jsonErrorResponse($data, "Branch not assign to this user");
            }

        }catch (\Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['url'] = route('home');
        return $this->jsonSuccessResponse($data, 'Set Default Branch');
    }
    public function defaultProjectStore(Request $request)
    {
        $data = [];
        $validator = Validator::make($request->all(), [
            'project_id' => ['required',Rule::notIn([0,'0'])],
        ],[
            'project_id.required' => 'Project is required',
            'project_id.not_in' => 'Project is required',
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

            $user = User::with('projects')->where('id',auth()->user()->id)->first();
            $checkExistsProject = false;
            if(!empty($user->projects)){
                foreach ($user->projects as $project){
                    if($project->id == $request->project_id){
                        $checkExistsProject = true;
                    }
                }
            }
            if($checkExistsProject){
                $user->project_id = $request->project_id;
                $user->save();

                session(['user_project' => $request->project_id]);

            }else{
                return $this->jsonErrorResponse($data, "Project not assign to this user");
            }

        }catch (\Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage());
        }
        DB::commit();
        $data['url'] = route('home');
        return $this->jsonSuccessResponse($data, 'Set Default Project');
    }

    public function branchStore(Request $request)
    {
        // dd($request->toArray());
        $data = [];
        $validator = Validator::make($request->all(), [
            'branches' => 'required'
        ]);
        if ($validator->fails()) {
            $data['validator_errors'] = $validator->errors();
            return $this->jsonErrorResponse($data, trans('message.required_fields'), 422);
        }
        $getAllBranches = Utilities::getAllBranches();
        $arr = [];
        foreach($getAllBranches as $branch){
            array_push($arr,$branch->id);
        }
        if (!in_array($request->branches,$arr)) {
            return $this->jsonErrorResponse($data, trans('message.required_fields'), 422);
        }
        DB::beginTransaction();
        try {
            $user = User::where('id', auth()->user()->id)->where(Utilities::CompanyProjectId())->first();
            $user->project_id = $request->branches;
            $user->save();
            session(['user_branch' => $request->branches]);
        }catch (QueryException $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        } catch (ValidationException $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        } catch (Exception $e) {
            DB::rollback();
            return $this->jsonErrorResponse($data, $e->getMessage(), 200);
        }
        DB::commit();

        return $this->jsonSuccessResponse($data, '', 200);
    }



}
