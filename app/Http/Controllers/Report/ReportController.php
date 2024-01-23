<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function customerLedger(){
        $name = 'customer';
        $title = 'Customer Ledger';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;

        $data['permission_view'] = $view;

        return view('reports.customerLedger',compact('data'));
    }

    // public function customerLedgerReport(Request $request)
    public function store(Request $request)
    {

        $name = 'customer';
        $title = 'Customer Ledger Report';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;

        $data['permission_view'] = $view;
        $cst = Customer::where('id',$request->customer_id)->first();
        $vouchers = Voucher::where('chart_account_code',$cst->coa_code)->get();
        // dd($vouchers);
        $data['vouchers'] = $vouchers;
        return view('reports.customerLedgerReport',compact('data'));
    }

}
