<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //Customer Report Section
    public function customerLedger(){
        $name = 'customer';
        $title = 'Customer Ledger';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;

        $data['permission_view'] = $view;

        return view('reports.customer.customerLedger',compact('data'));
    }

    public function customerLedgerReport(Request $request)
    {

        $name = 'customer';
        $title = 'Customer Ledger Report';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['company'] = Company::first();
        $data['title'] = $title;
        $data['report_name'] = $title;
        $data['permission_view'] = $view;

        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $cst = Customer::where('id',$request->customer_id)->first();
        $vouchers = Voucher::where('chart_account_code',$cst->coa_code)->whereBetween('created_at', [$from_date, $to_date])->get();
        // dd($vouchers);
        $data['vouchers'] = $vouchers;
        return view('reports.customer.customerLedgerReport',compact('data'));
    }

    //cash Currency Report Section
    public function currencyLedger(){

        $name = 'currency_legder';
        $title = 'Currency Ledger';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;

        $data['permission_view'] = $view;

        return view('reports.currency.currencyLedger',compact('data'));
    }

    public function currencyLedgerReport(Request $request)
    {
        // dd('in currency chart code');
        $name = 'currency-ledger';
        $title = 'Cash Currency Ledger Report';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;
        $data['report_name'] = 'Cash Currency Ledger Report';
        $data['company'] = Company::first();

        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['permission_view'] = $view;

        $coa = ChartOfAccount::where('id',$request->chart_id)->first();
        // $cst = Customer::where('id',$request->customer_id)->first();
        $vouchers = Voucher::where('chart_account_code',$coa->code)->whereBetween('created_at', [$from_date, $to_date])->get();

        $vouchers_list = [];
        foreach($vouchers as $v){
            $vouchers_list[$v->voucher_no] = $v;
        }
        // dd($vouchers_list);
        $data['vouchers'] = $vouchers;
        return view('reports.currency.currencyLedgerReport',compact('data'));
    }

    //bank Currency Report Section
    public function bankCurrencyLedger(){

        $name = 'bank_currency_legder';
        $title = 'Bank Currency Ledger';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;

        $data['permission_view'] = $view;

        return view('reports.bank_currency.currencyLedger',compact('data'));
    }

    public function bankCurrencyLedgerReport(Request $request)
    {
        // dd('in currency chart code');
        $name = 'bank-currency-ledger';
        $title = 'Bank Currency Ledger Report';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;
        $data['report_name'] = 'Bank Currency Ledger Report';
        $data['company'] = Company::first();

        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $data['permission_view'] = $view;
        // dump($request->all());
        $coa = ChartOfAccount::where('id',$request->chart_id)->first();
        // $cst = Customer::where('id',$request->customer_id)->first();
        $vouchers = Voucher::where('chart_account_code',$coa->code)->whereBetween('created_at', [$from_date, $to_date])->get();
        // dd($vouchers);
        $data['vouchers'] = $vouchers;
        return view('reports.bank_currency.currencyLedgerReport',compact('data'));
    }

    public function vouchersList (){

        $name = 'vouchers-list';
        $title = 'All Vouchers';
        $report_name = 'All Vouchers List';

        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;
        $data['report_name'] = $report_name;

        $data['permission_view'] = $view;

        $vouchers = Voucher::select('type')->get();
        $result = array();
        foreach ($vouchers as $key => $value){
          if(!in_array($value, $result))
            $result[$key]=$value;
        }
        $data['vouchers'] = $result;
        return view('reports.vouchers.list',compact('data'));
    }

    public function voucherLedger(Request $request)
    {
        // dd($request->all());
        $name = 'vouchers-list-view';
        $title = 'Vouchers';
        // $list_url = route('master.customer.index');
        $view = $name . "-view";

        $data = [];
        $data['title'] = $title;
        $data['company'] = Company::first();
        $type = $request->voucher_type;
        $voucher_name = '';
        if($type == 'CPV'){
            $voucher_name = 'Cash Payment Vouchers';
        }else if($type == 'BPV'){
            $voucher_name = 'Bank Payment Vouchers';
        }else if($type == 'CRV'){
            $voucher_name = 'Cash Receive Vouchers';
        }else if($type == 'BRV'){
            $voucher_name = 'Bank Receive Vouchers';
        }else if($type == 'SIV'){
            $voucher_name = 'Sale Invoice Vouchers';
        }else if($type == 'OBV'){
            $voucher_name = 'Opening Balance Vouchers';
        }else if($type == 'CST'){
            $voucher_name = 'Customer Voucher';
        }else{
            $voucher_name = 'Other Voucher';
        }
        $data['report_name'] = $voucher_name;

        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $data['permission_view'] = $view;
        // dump($from_date);
        // dd($to_date);

        $vouchers = Voucher::where('type',$type)->whereBetween('created_at', [$from_date, $to_date])->get();

        // dd($vouchers);
        $data['vouchers'] = $vouchers;
        return view('reports.vouchers.voucherReport',compact('data'));
    }

}
