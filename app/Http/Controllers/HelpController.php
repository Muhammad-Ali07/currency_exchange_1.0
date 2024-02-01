<?php

namespace App\Http\Controllers;

use App\Library\Utilities;
use App\Models\ChartOfAccount;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelpController extends Controller
{
    public function chart($val = null)
    {
        $data = [];
        $chart = ChartOfAccount::where('level',4);
        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name')->get();
        //dd($chart);
        $data['chart'] =  $chart;

        return view('helps.chart_help',compact('data'));
    }

    public function customer($val = null)
    {
        $data = [];
        $customer = Customer::where('id','<>',0);
        if(!empty($val)){
            $val = (string)$val;
            $customer = $customer->where('contact_no','like',"%$val%");
            $customer = $customer->orWhere('name','like',"%$val%");
        }

        $customer = $customer->select('id','contact_no','name')->get();
        //dd($chart);
        $data['customer'] =  $customer;
        return view('helps.customer_help',compact('data'));
    }

    public function oldCustomerHelp($val = null)
    {
        // dd('in old');
        $data = [];
        $customer = Customer::where('id','<>',0);
        if(!empty($val)){
            $val = (string)$val;
            $customer = $customer->where('contact_no','like',"%$val%");
            $customer = $customer->orWhere('name','like',"%$val%");
        }

        $customer = $customer->select('id','contact_no','name')->get();
        //dd($chart);
        $data['old_customer'] =  $customer;

        return view('helps.old_customer_help',compact('data'));
    }

    public function supplier($val = null)
    {
        // dd('in help');
        $data = [];
        $supplier = Supplier::where('id','<>',0);
        if(!empty($val)){
            $val = (string)$val;
            $supplier = $supplier->where('contact_no','like',"%$val%");
            $supplier = $supplier->orWhere('name','like',"%$val%");
        }

        $supplier = $supplier->select('id','contact_no','name')->get();
        //dd($chart);
        $data['supplier'] =  $supplier;
        return view('helps.supplier_help',compact('data'));
    }


    public function propertyProduct(Request $request)
    {

        $sale = Sale::where('project_id',$request->project_id)->pluck('product_id')->unique()->toArray();

        $data = [];
        $product = Product::whereNotIn('id',$sale)->where('product_form_type','property');
        if(!empty($val)){
            $val = (string)$val;
            $product = $product->where('code','like',"%$val%");
            $product = $product->orWhere('name','like',"%$val%");
        }

        $product = $product->select('id','code','name','default_sale_price')->get();
        //dd($chart);
        $data['property'] =  $product;

        return view('helps.product_help',compact('data'));
    }
    public function productHelp(Request $request)
    {
        // dd('in help');
        // $sale = Sale::where('project_id',$request->project_id)->pluck('product_id')->unique()->toArray();

        $data = [];
        // $product = Product::whereNotIn('id',$sale)->where('product_form_type','property');
        $product = Product::where(Utilities::CurrentBC())->where('product_form_type','currency');

        if(!empty($val)){
            $val = (string)$val;
            $product = $product->where('code','like',"%$val%");
            $product = $product->orWhere('name','like',"%$val%");
        }

        $product = $product->select('id','code','name','stock_in')->get();
        //dd($chart);
        $data['product'] =  $product;

        return view('helps.product_help',compact('data'));
    }

    public function toProductHelp(Request $request)
    {
        // dd('in help');
        // $sale = Sale::where('project_id',$request->project_id)->pluck('product_id')->unique()->toArray();

        $data = [];
        // $product = Product::whereNotIn('id',$sale)->where('product_form_type','property');
        $product = Product::where(Utilities::CurrentBC())->where('product_form_type','currency');

        if(!empty($val)){
            $val = (string)$val;
            $product = $product->where('code','like',"%$val%");
            $product = $product->orWhere('name','like',"%$val%");
        }

        $product = $product->select('id','code','name','stock_in')->get();
        //dd($chart);
        $data['product'] =  $product;

        return view('helps.product_help_new',compact('data'));
    }

    public function transactionTypeHelp(Request $request)
    {
        // dd('in help');
        // $sale = Sale::where('project_id',$request->project_id)->pluck('product_id')->unique()->toArray();

        $data = [];
        // $product = Product::whereNotIn('id',$sale)->where('product_form_type','property');
        // $product = Product::where(Utilities::CurrentBC())->where('product_form_type','currency');

        // if(!empty($val)){
        //     $val = (string)$val;
        //     $product = $product->where('code','like',"%$val%");
        //     $product = $product->orWhere('name','like',"%$val%");
        // }

        // $product = $product->select('id','code','name')->get();
        $data['transaction_types'] = ['Buy', 'Sell'];

        // dd($data);
        // $data['product'] =  $product;

        return view('helps.transaction_type_help',compact('data'));
    }

    public function currencyChartHelp($val = null)
    {
        //cash currency ledger
        $data = [];
        $chart = ChartOfAccount::where('level',4)
                // ->where('parent_account_code','01-02-0001-0000');
                ->where('parent_account_code','01-02-0002-0000');

        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name')->get();
        //dd($chart);
        $data['chart'] =  $chart;

        return view('helps.chart_help_for_report',compact('data'));
    }

    public function bankCurrencyChartHelp($val = null)
    {
        // dd('in help');
        //cash currency ledger
        $data = [];
        $chart = ChartOfAccount::where('level',4)
                ->where('parent_account_code','01-02-0001-0000');
                // ->where('parent_account_code','01-02-0002-0000');

        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name')->get();
        // dd($chart);
        $data['chart'] =  $chart;

        return view('helps.bank_currency_chart',compact('data'));
    }

    public function bankCurrencyHelp($val = null)
    {
        // dd('in help');
        //cash currency ledger
        $data = [];
        $chart = ChartOfAccount::where('level',4)
                ->where('parent_account_code','01-02-0001-0000');
                // ->where('parent_account_code','01-02-0002-0000');

        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name','product_id')->get();
        // dd($chart);
        $data['chart'] =  $chart;

        return view('helps.bank_currency_help',compact('data'));
    }

    public function cashCurrencyHelp($val = null)
    {
        //cash currency ledger
        $data = [];
        $chart = ChartOfAccount::where('level',4)
                // ->where('parent_account_code','01-02-0001-0000');
                ->where('parent_account_code','01-02-0002-0000');

        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name','product_id')->get();
        //dd($chart);
        $data['chart'] =  $chart;

        return view('helps.cash_currency_help',compact('data'));
    }

    public function buyCashCurrencyHelp($val = null)
    {
        //cash currency ledger
        $data = [];
        $chart = ChartOfAccount::where('level',4)
                // ->where('parent_account_code','01-02-0001-0000');
                ->where('parent_account_code','01-02-0002-0000');

        if(!empty($val)){
            $val = (string)$val;
            $chart = $chart->where('code','like',"%$val%");
            $chart = $chart->orWhere('name','like',"%$val%");
        }

        $chart = $chart->select('id','code','name','product_id')->get();
        //dd($chart);
        $data['chart'] =  $chart;

        return view('helps.buy_cash_currency_help',compact('data'));
    }


}
