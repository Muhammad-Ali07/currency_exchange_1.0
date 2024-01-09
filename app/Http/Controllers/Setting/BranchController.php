<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     private static function Constants()
     {
         $name = 'branch';
         return [
             'title' => 'Branch',
             'list_url' => route('setting.branch.index'),
             'list' => "$name-list",
             'create' => "$name-create",
             'edit' => "$name-edit",
             'delete' => "$name-delete",
             'view' => "$name-view",
         ];
     }
     public function index(Request $request)
     {
         $data = [];
         $data['title'] = self::Constants()['title'];
         $data['permission_list'] = self::Constants()['list'];
         $data['permission_create'] = self::Constants()['create'];
        //  dd($request->ajax());
         if ($request->ajax()) {
             $draw = 'all';
            //  dd('in request');
             $dataSql = Branch::with('company')->where(Utilities::CompanyId());

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
                 $urlEdit = route('setting.branch.edit',$row->uuid);
                 $urlDel = route('setting.branch.destroy',$row->uuid);

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
                     $row->company->name,
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

         return view('setting.branch.list', compact('data'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }
}
