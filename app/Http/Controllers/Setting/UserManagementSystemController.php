<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Library\Utilities;
use App\Models\Defi\TblDefiArea;
use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// db and Validator
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;

class UserManagementSystemController extends Controller
{


    private static function Constants()
    {
        return [
            'title' => 'User Management',
            'create_url' => route('setting.user-management.create'),
        ];
    }

    public static function adminMenuList(){
        $data = [];
        $smenu = 'sidebar-menu';
        $list = 'list';
        $create = 'create';
        $edit = 'edit';
        $view = 'view';
        $delete = 'delete';
        $print = 'print';
        $data['module_act'] = [$smenu,$list,$create,$edit,$view,$delete,$print];

        $data['admin_menu'] = [
            [
                'name' => 'Common',
                'icon' => '',
                'child' => [
                    ['dname'=>'Home', 'name' => 'home', 'action' => [ $smenu,$view ] ],
                    ['dname'=>'Company', 'name' => 'company', 'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ] ],
                    // ['dname'=>'Project', 'name' => 'project','action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ] ],
                ],
            ],
            // Accounts
            [
                'name' => 'Accounts',
                'icon' => 'icon-xl la la-cog',
                'child' => [
                    [
                        'dname' => 'Chart of Account',
                        'name' => 'chart-of-account',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Chart of Account Tree',
                        'name' => 'chart-of-account-tree',
                        'action' => [ $smenu,$list,$view ]
                    ],
                    [
                        'dname' => 'Bank Payment',
                        'name' => 'bank-payment',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Bank Receive',
                        'name' => 'bank-receive',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Cash Payment',
                        'name' => 'cash-payment',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Cash Receive',
                        'name' => 'cash-receive',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Journal',
                        'name' => 'journal',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                ]
            ],
            // Master
            [
                'name' => 'Master',
                'icon' => 'icon-xl la la-shopping-cart',
                'child' => [
                    [
                        'dname' => 'Customer',
                        'name' => 'customer',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Supplier',
                        'name' => 'supplier',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Product',
                        'name' => 'product',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],

                ]
            ],
            // Transactional Forms
            [
                'name' => 'Invoice',
                'icon' => 'icon-xl la la-shopping-cart',
                'child' => [
                    [
                        'dname' => 'Product Property',
                        'name' => 'product-property',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Sale',
                        'name' => 'sale',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Purchase',
                        'name' => 'purchase',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Return',
                        'name' => 'return',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],

                ]
            ],
            // HR
            // [
            //     'name' => 'HR',
            //     'icon' => 'icon-xl la la-cog',
            //     'child' => [
            //         [
            //             'dname' => 'Department',
            //             'name' => 'department',
            //             'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
            //         ],
            //         [
            //             'dname' => 'Staff',
            //             'name' => 'staff',
            //             'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
            //         ],
            //     ]
            // ],

            // REPORT
            [
                'name' => 'Report',
                'icon' => 'icon-xl la la-clipboard',
                'child' => [
                    [
                        'dname' => 'Account Ledger',
                        'name' => 'accounting_ledger',
                        'action' => [ $view ]
                    ],
                    [
                        'dname' => 'Profit&Loss Statement',
                        'name' => 'profit_loss_statement',
                        'action' => [ $view ]
                    ],
                ]
            ],
            // setting
            [
                'name' => 'Setting',
                'icon' => 'icon-xl la la-cog',
                'child' => [
                    [
                        'dname' => 'User',
                        'name' => 'user',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'User Management',
                        'name' => 'user-management',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Branch',
                        'name' => 'branch',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                ]
            ],
        ];

        return $data;
    }
    public static function adminMenuListOld(){
        $data = [];
        $smenu = 'sidebar-menu';
        $list = 'list';
        $create = 'create';
        $edit = 'edit';
        $view = 'view';
        $delete = 'delete';
        $print = 'print';
        $data['module_act'] = [$smenu,$list,$create,$edit,$view,$delete,$print];

        $data['admin_menu'] = [
            [
                'name' => 'Common',
                'icon' => '',
                'child' => [
                    ['dname'=>'Home', 'name' => 'home', 'action' => [ $smenu,$view ] ],
                    ['dname'=>'Company', 'name' => 'company', 'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ] ],
                    ['dname'=>'Project', 'name' => 'project','action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ] ],
                ],
            ],
            // Accounts
            [
                'name' => 'Accounts',
                'icon' => 'icon-xl la la-cog',
                'child' => [
                    [
                        'dname' => 'Chart of Account',
                        'name' => 'chart-of-account',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Chart of Account Tree',
                        'name' => 'chart-of-account-tree',
                        'action' => [ $smenu,$list,$view ]
                    ],
                    [
                        'dname' => 'Bank Payment',
                        'name' => 'bank-payment',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'test Payment',
                        'name' => 'test-payment',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Bank Receive',
                        'name' => 'bank-receive',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Cash Payment',
                        'name' => 'cash-payment',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Cash Receive',
                        'name' => 'cash-receive',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Journal',
                        'name' => 'journal',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                ]
            ],
            // Purchase
            [
                'name' => 'Purchase',
                'icon' => 'icon-xl la la-shopping-cart',
                'child' => [
                    [
                        'dname' => 'Inventory',
                        'name' => 'inventory',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Product Inventory',
                        'name' => 'product',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Category Type',
                        'name' => 'category-type',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Category',
                        'name' => 'category',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Brand',
                        'name' => 'brand',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Supplier',
                        'name' => 'supplier',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Manufacturer',
                        'name' => 'manufacturer',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Property Type',
                        'name' => 'property-type',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Product Variation',
                        'name' => 'product-variation',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                ]
            ],
            // Sale
            [
                'name' => 'Sale',
                'icon' => 'icon-xl la la-shopping-cart',
                'child' => [
                    [
                        'dname' => 'Dealer',
                        'name' => 'dealer',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Customer',
                        'name' => 'customer',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Booking',
                        'name' => 'sale-invoice',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Booking Transfer',
                        'name' => 'booking-transfer',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                ]
            ],
            // HR
            [
                'name' => 'HR',
                'icon' => 'icon-xl la la-cog',
                'child' => [
                    [
                        'dname' => 'Department',
                        'name' => 'department',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Staff',
                        'name' => 'staff',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                ]
            ],

            // REPORT
            [
                'name' => 'Report',
                'icon' => 'icon-xl la la-clipboard',
                'child' => [
                    [
                        'dname' => 'Account Ledger',
                        'name' => 'accounting_ledger',
                        'action' => [ $view ]
                    ],
                    [
                        'dname' => 'Profit&Loss Statement',
                        'name' => 'profit_loss_statement',
                        'action' => [ $view ]
                    ],
                ]
            ],
            // setting
            [
                'name' => 'Setting',
                'icon' => 'icon-xl la la-cog',
                'child' => [
                    [
                        'dname' => 'Country',
                        'name' => 'country',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'Region',
                        'name' => 'region',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'City',
                        'name' => 'city',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'User Management',
                        'name' => 'user-management',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                    [
                        'dname' => 'User',
                        'name' => 'user',
                        'action' => [ $smenu,$list,$create,$edit,$view,$delete,$print ]
                    ],
                ]
            ],
        ];

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    { // for admin

        $data['title'] = self::Constants()['title'];
        $data['create_url'] = self::Constants()['create_url'];
        if (isset($id)) {
            if (User::where('id','LIKE',$id)->exists()) {
                $user = User::where('id','LIKE',$id)->first();
                $data['user_per_list'] = PermissionUser::where('user_id',$user->id)->pluck('permission_id')->toArray();
                $data['id'] = $id;
            } else {
                abort('404');
            }
        }
        $data['users'] = User::get();
        $data['permission_list'] = Permission::pluck('id','name')->toArray();
        $data['menus'] = self::adminMenuList();

      //  dd($data['permission_list']);
        return view('setting.user_management.form',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {

        $data = [];
        /*if(!auth()->user()->isAbleTo(self::$permission_name.'-edit') && auth()->user()->super_admin == 0){
            session()->flash('status', 'error');
            session()->flash('message','You have no permission');
            return redirect()->back();
        }*/
        DB::beginTransaction();
        try{
            $perAll = Permission::pluck('id')->toArray();
            $user = User::where('id',$request->user_id)->first();
            if(!empty($user)){
                $permissions = ($request->has('permissions') && $request->filled('permissions'))?$request->permissions:[];
                $permissions = array_filter($permissions);
                $permissions = array_slice($permissions,0);
                $user->detachPermissions($perAll);
                $user->attachPermissions($permissions);
            }

        } catch (Exception $e) {
            DB::rollback();
            session()->flash('status', 'error');
            session()->flash('message', $e->getMessage());
            return redirect()->back();
        }
        DB::commit();

        session()->flash('status', 'success');
        session()->flash('message', 'User permission updated');
        return redirect()->back();
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
