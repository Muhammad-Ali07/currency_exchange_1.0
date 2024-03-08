@extends('layouts.form')
@section('title', $data['title'])
@section('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 800px;
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .show .modal-dialog {
            /*position: absolute;*/right: 0px !important;
        }
        .right.fade .modal-dialog {
            right: -320px;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }
        .right.fade.in .modal-dialog {
            right: 0;
        }
        /* .note-editor .note-toolbar, .note-popover .popover-content{
            background: #8989911f !important;
        } */

    </style>
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $entry_date = date('Y-m-d');
        $code = '';
    @endphp

    <form id="sale_invoice_create" class="sale_invoice_create" action="{{route('transaction.sale.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" id="form_type" value="sale_invoice">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            <button type="submit" disabled class="btn btn-success btn-sm waves-effect waves-float waves-light transaction_save_btn" id="transaction_save_btn">Save</button>
                        </div>
                        <div class="card-link">
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="col-sm-3">
                                    <h4><b id="code">{{$data['code']}}</b></h4>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Form Type</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form_type" type="radio" name="form_type" id="sell" value="sell">
                                            <label class="form-check-label" for="inlineRadio1">SELL</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form_type" type="radio" name="form_type" id="buy" value="buy">
                                            <label class="form-check-label" for="inlineRadio2">BUY</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input form_type" type="radio" name="form_type" id="convert" value="convert">
                                            <label class="form-check-label" for="inlineRadio2">Convert</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">

                            </div>
                            <div class="col-lg-8">
                                <hr>
                            </div>
                            <div class="col-lg-2">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Entry Date</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" id="entry_date" name="entry_date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($entry_date))}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row" id="buy">
                                    <h6 id="buy_h6">Receive</h6>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Currency code <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group eg_help_block w-100">
                                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                    <input disabled id="buy_cash_chart_name" type="text" placeholder="Click here..." class="buy_cash_chart_name form-control form-control-sm text-left">
                                                    <input id="buy_cash_chart_id" type="hidden" name="buy_cash_chart_id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Balance<span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="stock_in" readonly name="total_balance" type="text" class="stock_in form-control form-control-sm text-left">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Quantity</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" disabled class="form-control form-control-sm" id="quantity" name="quantity" aria-invalid="false">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row convert" style="display: none;">
                                    <div class="row math_formula" style="display: none;">
                                        <div class="col-sm-4">
                                            <label class="col-form-label">Formula</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input old_formula" type="radio" name="old_formula" id="old_multiply" value="multiply">
                                                <label class="form-check-label" for="inlineRadio1">Multiply</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input old_formula" type="radio" name="old_formula" id="old_divide" value="divide">
                                                <label class="form-check-label" for="inlineRadio2">Divide</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 old_exchange_rate">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="col-form-label">Old Exchange Rate <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input id="market_rate" disabled name="market_rate" type="text" placeholder="Click here..." value="" class="market_rate form-control form-control-sm text-left">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 old_exchange_amount">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="col-form-label">Old Exchange Amount <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input id="old_buying_amount" readonly name="old_buying_amount" type="text" placeholder="Click here..." value="" class="old_buying_amount form-control form-control-sm text-left">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="mb-1 row" id="sell" style="display: none">
                                    <h6>Sell</h6>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Product <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group eg_help_block">
                                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                    <input id="to_product_name" type="text" placeholder="Click here..." class="to_product_name form-control form-control-sm text-left">
                                                    <input id="to_product_id" type="hidden" name="to_product_id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Balance<span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input id="to_stock_in" type="text" disabled class="to_stock_in form-control form-control-sm text-left">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="mb-1 row" id="customerRow" style="display:none;">
                                    <h6>Paid</h6>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Customer <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group eg_help_block">
                                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                    <input id="customer_name" type="text" placeholder="Click here..." class="customer_name form-control form-control-sm text-left">
                                                    <input id="customer_id" type="hidden" name="customer_id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Balance</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input id="customer_balance" type="text" readonly class="customer_balance form-control form-control-sm text-left">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row" id="supplierRow" style="display:none;">
                                    <div class="col-lg-3">
                                        <label class="col-form-label p-0">Supplier<span class="required">*</span></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="input-group eg_help_block">
                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                            <input id="supplier_name" type="text" placeholder="Click here..." name="supplier_name" class="supplier_name form-control form-control-sm text-left">
                                            <input id="supplier_id" type="hidden" class="supplier_id" name="supplier_id">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="mb-1 row">

                                    <div class="col-lg-4">
                                        <label class="col-form-label">Payment<span class="required">*</span></label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input payment" disabled type="radio" name="payment" id="completed" value="completed" checked="">
                                            <label class="form-check-label" for="inlineRadio1">Complete</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input payment" disabled type="radio" name="payment" id="partial" value="partial">
                                            <label class="form-check-label" for="inlineRadio2">Partial</label>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="mb-1 row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Amount</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="amount" name="amount" aria-invalid="false">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="">
                                    <div class="">
                                        <div class="row mb-2">
                                            <div class="col-lg-6">
                                                <label class="form-label" for="payment-expiry">Payment Type</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="select2 form-select" disabled id="payment_type" name="payment_type">
                                                    <option value="">--Select--</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="bank">Bank</option>
                                                    {{-- <option value="both">Both</option> --}}

                                                </select>
                                            </div>
                                        </div>
                                        <h6 id="paid_h6">Paid</h6>


                                        <div class="mb-1 row" id="cash_code" style="display: none;">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">CIH code <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="input-group eg_help_block w-100">
                                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                            <input id="cash_chart_name" type="text" placeholder="Click here..." class="cash_chart_name form-control form-control-sm text-left">
                                                            <input id="cash_chart_id" type="hidden" name="cash_chart_id">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">CIH Balance <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input id="cih_balance" readonly name="cih_balance" type="text" placeholder="Click here..." value="" class="cih_balance balance form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="cih_amount" style="display: none">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">Amount<span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input name="cih_amount" type="text" placeholder="Enter..." value="" class="cih_amount form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-1 row" id="bank_code" style="display: none;">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">Bank code <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="input-group eg_help_block w-100">
                                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                            <input id="bank_chart_name" type="text" placeholder="Click here..." class="bank_chart_name form-control form-control-sm text-left">
                                                            <input id="bank_chart_id" type="hidden" name="bank_chart_id">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">Bank Bal <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input id="bank_balance" readonly name="bank_balance" type="text" placeholder="Click here..." value="" class="bank_balance balance form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="bank_amount" style="display: none">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">Amount<span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input id="bank_amount" name="bank_amount" type="text" placeholder="Enter..." value="" class="bank_amount form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">Market Rate <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input name="market_rate" id="bank_market_rate" class="bank_market_rate" type="text" placeholder="Click here..." value="" class="bank_market_rate form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label">Sell Rate <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input name="bank_sell_rate" id="bank_sell_rate"  type="text" placeholder="Click here..." value="" class="bank_sell_rate form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div> --}}

                                        </div>
                                        <div class="mb-1 row" >
                                            <div class="col-lg-12 old_exchange_rate" style="display: none;">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label">Old Exchange Rate <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input id="market_rate" disabled name="market_rate" type="text" placeholder="Click here..." value="" class="market_rate form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 old_exchange_amount" style="display: none;">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label">Old Exchange Amount <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input id="old_buying_amount" disabled name="old_buying_amount" type="text" placeholder="Click here..." value="" class="old_buying_amount form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label">Formula</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input formula" type="radio" name="formula" id="multiply" value="multiply">
                                                            <label class="form-check-label" for="inlineRadio1">Multiply</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input formula" type="radio" name="formula" id="divide" value="divide">
                                                            <label class="form-check-label" for="inlineRadio2">Divide</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label">Exchange Rate <span class="required">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input id="cih_sell_rate" disabled name="cih_sell_rate" type="text" placeholder="Click here..." value="" class="cih_sell_rate form-control form-control-sm text-left">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 row" style="display:none;">
                                            <div class="col-lg-6">
                                                <h5 class="card-title">Gain Amount/Unit</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <h5 class="card-title text-primary float-end" id="gain_amount_per_unit"></h5>
                                                <input type="hidden" name="gain_amount_per_unit" class="gain_amount_per_unit form-control form-control-sm text-left">
                                            </div>
                                        </div>
                                        <div class="mb-1 row gain_row" style="display:none;">
                                            <div class="col-lg-6">
                                                <h5 class="card-title expense_amount">Expense Amount</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <h5 class="card-title text-primary float-end" id="total_gain_amount"></h5>
                                                <input type="hidden" id="gain_amount" name="gain_amount" class="gain_amount form-control form-control-sm text-left">
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-lg-6">
                                                <h5 class="card-title">Current Amount</h5>
                                            </div>
                                            <div class="col-lg-6">
                                                <h5 class="card-title text-primary float-end" id="amount">$0.00</h5>
                                                <input type="hidden" name="amount" class="amount form-control form-control-sm text-left">
                                                <input type="hidden" name="current_amount" class="amount form-control form-control-sm text-left">

                                            </div>
                                        </div>
                                        <div class="mb-1 row" style="display:none" id="payment_method">
                                            <div class="col-lg-6">
                                                <label>Amount Paid to Customer</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input name="amt_paid_to_customer" id="amt_paid_to_customer"  type="text" placeholder="Enter Amount..." value="" class="amt_paid_to_customer form-control form-control-sm text-left">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <div class="data_entry_header">
                                        <div class="hiddenFiledsCount" style="display: inline-block;"><span>0</span> fields hide</div>
                                        <div style="display: inline-block;">
                                            <button type="button" disabled class="btn btn-sm btn-primary" id="gridAddBtn">Add</button>
                                        </div>
                                        <div class="dropdown chart-dropdown" style="display: inline-block;">
                                            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                            @php
                                                $headings = ['Account Code','Received','Paid','Exchange Rate','Debit(FC)','Credit(FC)','Debit(LC)','Credit(LC)',];
                                            @endphp
                                            <ul class="listing_dropdown dropdown-menu dropdown-menu-end">
                                                @foreach($headings as $key=>$heading)
                                                    <li class="dropdown-item">
                                                        <label>
                                                            <input value="{{$key}}" type="checkbox" checked> {{$heading}}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <div class="col-lg-12">
                                    <div id="erp_grid_table" class="egt">
                                        <div class="">
                                            <div class="table-scroll ">
                                                <table class="egt_form_table table table-bordered">
                                                    <thead class="egt_form_header">
                                                    <tr class="egt_form_header_title">
                                                        <th width="20%">Account Code</th>
                                                        <th width="20%">Description</th>

                                                        <th width="22%">Received</th>
                                                        <th width="22%">Paid</th>

                                                        <th width="22%">Local Rate</th>

                                                        <th width="22%">Exchange Rate</th>
                                                        {{-- <th width="20%">Paid Currency Code</th> --}}
                                                        <th width="22%">Debit(FC)</th>
                                                        <th width="22%">Credit(FC)</th>

                                                        <th width="22%">Debit(LC)</th>
                                                        <th width="22%">Credit(LC)</th>
                                                        <th width="13%" class="text-center">Action</th>
                                                    </tr>
                                                    {{-- <tr class="egt_form_header_input">
                                                        <td>
                                                            <input id="egt_sr_no" readonly type="text" class="form-control form-control-sm">
                                                            <input id="chart_id" type="hidden" class="chart_id form-control form-control-sm">
                                                        </td>
                                                        <td>
                                                            <input id="egt_chart_code" type="text" class="chart_code form-control form-control-sm text-left" placeholder="Press F2">
                                                        </td>
                                                        <td>
                                                            <input id="egt_chart_name" type="text" class="chart_name form-control form-control-sm" readonly>
                                                        </td>
                                                        <td>
                                                            <input id="egt_cheque_no" type="text" class="cheque_no form-control form-control-sm">
                                                        </td>
                                                        <td>
                                                            <input id="egt_cheque_date" type="text" class="cheque_date form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="Click & Select Date">
                                                        </td>
                                                        <td>
                                                            <input id="egt_description" type="text" class="form-control form-control-sm">
                                                        </td>
                                                        <td>
                                                            <input id="egt_amount" type="text" class="form-control form-control-sm">
                                                        </td>
                                                        <td>
                                                            <input id="egt_rate" type="text" class="form-control form-control-sm">
                                                        </td>
                                                        <td>
                                                            <input id="egt_debit" type="text" class="FloatValidate debit form-control form-control-sm">
                                                        </td>
                                                        <td>
                                                            <input id="egt_credit" type="text" class="FloatValidate credit form-control form-control-sm">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" id="egt_add" class="egt_add btn btn-primary btn-sm">
                                                                <i data-feather='plus'></i>
                                                            </button>
                                                        </td>
                                                    </tr> --}}
                                                    </thead>
                                                    <tbody class="egt_form_body">
                                                    </tbody>
                                                    <tfoot class="egt_form_footer">
                                                    <tr class="egt_form_footer_total">
                                                        <td class="voucher-total-title">Total</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="voucher-total-debit text-end">
                                                            <span id="tot_debit"></span>
                                                            <input id="tot_voucher_debit" name="tot_voucher_debit" type="hidden" >
                                                        </td>
                                                        <td class="voucher-total-credit text-end">
                                                            <span id="tot_credit"></span>
                                                            <input id="tot_voucher_credit" name="tot_voucher_credit" type="hidden" >
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-form-label">Remarks</label>
                                <div class="col-lg-12">
                                    <div class="row">
                                        {{-- <div class="col-sm-3">
                                        </div> --}}
                                        <div class="col-sm-12">
                                            <textarea name="remarks" class="form-control form-control-sm" id="summernote" ></textarea>
                                            {{-- <div id="summernote"><p></p></div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- <div class="modal fade right" id="createNewCustomer" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" style="">
            <div class="modal-content" id="modal_create_customer">
                <div class="modal-body " style="height:100vh">
                    @php
                        $modal = true;
                    @endphp
                    @include('sale.customer.form')
                </div>
            </div>
        </div>
    </div> --}}
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/sale/sale_invoice/create.js') }}"></script>
    @yield('pageJsScript')
@endsection

@section('script')
    <script src="{{asset('/pages/help/customer_help.js')}}"></script>
    <script src="{{asset('/pages/help/product_help.js')}}"></script>
    <script src="{{asset('/pages/help/product_help_new.js')}}"></script>
    <script src="{{asset('/pages/help/transaction_type_help.js')}}"></script>
    <script src="{{ asset('/pages/help/supplier_help.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

      <script>
          var entry_date = $('#entry_date');
          if (entry_date.length) {
              entry_date.flatpickr({
                  dateFormat: 'd-m-Y',
              });
          }
        $('#summernote').summernote({
          placeholder: 'Write here',
          tabsize: 2,
          height: 120,
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            // ['table', ['table']],
            // ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen']]

            // ['view', ['fullscreen', 'codeview', 'help']]
          ]
        });
      </script>
      <script>
        $(document).on('change','#payment_type',function(){
            var payment_type = $('#payment_type').val();
            if(payment_type == 'cash'){
                $('#bank_code').css('display','none');
                $('#cash_code').show();
            }else if(payment_type == 'bank'){
                $('#cash_code').css('display','none');
                $('#bank_code').show();
            }else{

                $('#bank_code').show();
                $('#cash_code').show();
                $('#cih_amount').show();
                $('#bank_amount').show();

            }
        });

        $(document).on('change','.payment',function(){
            var payment_method = $(this).val();
            if(payment_method == 'completed'){
                $('#payment_method').find('#amt_paid_to_customer').val('');
                $('#payment_method').css('display','none');
            }else{
                $('#payment_method').show();
            }
        });

        // $(document).on('click','#other_currency',function(){
        //     // var other_currency = $('#other_currency').val();
        //     $('#sell').show();
        // });
        // $(document).on('click','#home_currency',function(){
        //     // var other_currency = $('#other_currency').val();
        //     $('#sell').hide();
        // });
        $(document).on('keyup','#market_rate',function(){
            var old_rate = $(this).val();
            var market_rate = $('#market_rate').val();
            var total_buy_qty = $('#quantity').val();

            var form_type = $("input[name='form_type']:checked").val();
            // console.log(form_type);
            if(form_type == 'convert'){
                // in internal conversion
                var qty_to_exchange = $('#quantity').val();
                if(isNaN(qty_to_exchange) || qty_to_exchange == '' ){
                    qty_to_exchange = 0;
                }
                var old_exchange_rate = $('#market_rate').val();
                var formula = $("input[name='old_formula']:checked").val();
                if(formula == 'multiply'){
                    console.log(formula);
                    var old_exchange_amount = parseFloat(qty_to_exchange) * parseFloat(old_exchange_rate);
                }else{
                    console.log(formula);
                    var old_exchange_amount = parseFloat(qty_to_exchange) / parseFloat(old_exchange_rate);
                }
                // var old_exchange_amount = parseFloat(qty_to_exchange) / parseFloat(old_exchange_rate);
                console.log(old_exchange_amount);
                $('#old_buying_amount').val(old_exchange_amount.toFixed(3));
            }
            else if(form_type == 'sell'){
                var formula = $("input[name='old_formula']:checked").val();
                if(formula == 'multiply'){
                    console.log(formula);
                    var old_amount = parseFloat(total_buy_qty) * parseFloat(old_rate);
                }else{
                    console.log(formula);
                    var old_amount = parseFloat(total_buy_qty) / parseFloat(old_rate);
                }
                $('#old_buying_amount').val(parseFloat(old_amount.toFixed(3)));
                console.log(old_amount);
            }
            else{
                var old_amount = parseFloat(total_buy_qty) * parseFloat(old_rate);
                $('#old_buying_amount').val(parseFloat(old_amount.toFixed(3)));
            }

        });
        $(document).on('blur','#cih_sell_rate',function(){
            var sell_rate = $(this).val();
            var market_rate = $('#market_rate').val();
            var balance = $('.balance').val();
            if(balance == ''){
                balance = $('.bank_balance').val();
            }
            var form_type = $("input[name='form_type']:checked").val();
            var formula = $("input[name='formula']:checked").val();

            // console.log(form_type);
            //for buy and sell
            if(form_type != 'convert'){
                var gain_amount_per_unit =  parseFloat(sell_rate) - parseFloat(market_rate);

                $('#gain_amount_per_unit').text(parseFloat(gain_amount_per_unit.toFixed(3)));
                $('.gain_amount_per_unit').val(parseFloat(gain_amount_per_unit.toFixed(3)));

                var total_buy_qty = $('#quantity').val();
                if(isNaN(total_buy_qty) || total_buy_qty == '' ){
                    total_buy_qty = 0;
                }

                //functionality for calculating total amount to be paid
                if(formula == 'multiply'){
                    var amount = parseFloat(total_buy_qty) * parseFloat(sell_rate);
                }else{
                    var amount = parseFloat(total_buy_qty) / parseFloat(sell_rate);
                }
                var total_amount = '$0';
                // console.log(amount);
                    if(isNaN(amount)){
                        ntoastr.error('Error in amount...');
                    }else if(balance < amount){
                        // $('#transaction_save_btn').prop('disabled',true);
                        ntoastr.error('Insufficient balance...');
                    }else{
                        total_amount = '$' + parseFloat(amount.toFixed(3));
                    }
                    $('#amount').text(total_amount);
                    $('.amount').val(amount);

                    // var old_amount = $('#old_buying_amount').val();
                    // console.log(old_amount);
                    // var expense_amount = parseFloat(amount) - parseFloat(old_amount);
                    // console.log(expense_amount);
                    // var total_exp_amount = '$' + parseFloat(expense_amount.toFixed(3));

                    // $('#gain_amount').val(parseFloat(expense_amount.toFixed(3)));
                    // $('#total_gain_amount').text(total_exp_amount);
            }else{
                var qty_to_convert = $('#quantity').val();
                var formula = $("input[name='formula']:checked").val();
                if(formula == 'multiply'){
                    var amount = parseFloat(qty_to_convert) * parseFloat(sell_rate);
                }else{
                    var amount = parseFloat(qty_to_convert) / parseFloat(sell_rate);
                }

                var total_amount = '$0';
                // console.log(amount);
                if(isNaN(amount)){
                    ntoastr.error('Error in amount...');
                }else{
                    total_amount = '$' + parseFloat(amount.toFixed(3));
                }
                $('#amount').text(total_amount);
                $('.amount').val(amount);

                var old_amount = $('#old_buying_amount').val();
                console.log(old_amount);
                var expense_amount = parseFloat(old_amount) - parseFloat(amount);
                console.log(expense_amount);
                var total_exp_amount = '$' + parseFloat(expense_amount.toFixed(3));

                $('#gain_amount').val(parseFloat(expense_amount.toFixed(3)));
                $('#total_gain_amount').text(total_exp_amount);

            }
        });

        $(document).on('keyup','#bank_sell_rate',function(){
            var sell_rate = $(this).val();
            var market_rate = $('#bank_market_rate').val();

            var gain_amount_per_unit = parseFloat(market_rate) - parseFloat(sell_rate);

            $('#gain_amount_per_unit').text(gain_amount_per_unit);
            $('.gain_amount_per_unit').val(gain_amount_per_unit);

            var total_buy_qty = $('#quantity').val();

            // functionality for calculation of gain amount
            var gain_amount = parseFloat(total_buy_qty) * parseFloat(gain_amount_per_unit);
            var total_gain_amount = '$' + gain_amount;
            $('#gain_amount').val(gain_amount);
            $('#total_gain_amount').text(total_gain_amount);

            //functionality for calculating total amount to be paid
            var amount = parseFloat(total_buy_qty) * parseFloat(sell_rate);
            var total_amount = '$' + amount;
            $('#amount').text(total_amount);
            $('.amount').val(amount);
        });
        //Grid Add Button working
        $(document).on('click','#gridAddBtn',function(){

            //cash to cash transaction
            var rCurrencyChartName = $('#buy_cash_chart_name').val();
            var rCurrencyChartId = $('#buy_cash_chart_id').val();

            var pCurrencyChartName = $('#cash_chart_name').val();
            var pCurrencyChartId = $('#cash_chart_id').val();
            // console.log(pCurrencyChartId);
            if(pCurrencyChartId == ''){
                pCurrencyChartName = $('#bank_chart_name').val();
                pCurrencyChartId = $('#bank_chart_id').val();
            }

            var qty = $('#quantity').val();
            var cihSellRate = $('#cih_sell_rate').val();
            var amount = $('.amount').val();

            var form_type = $("input[name='form_type']:checked").val();
            if(form_type != 'convert'){
                if(form_type == 'sell'){
                    if(rCurrencyChartName != null && pCurrencyChartName != null && qty != '' && cihSellRate != '' && amount != 'NaN' ){
                        var tr = '';
                        tr = '<tr>'+
                                '<td>'+
                                    '<input type="hidden" name="account_id[]" class="rowRecChartID" readonly value="'+rCurrencyChartId+'">'+
                                    '<input type="text" name="account_code[]" class="form-control form-control-sm rowRecChartName" readonly value="'+rCurrencyChartName+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="desc[]" class="form-control form-control-sm" value="">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="qty[]" class="form-control form-control-sm rowQty" readonly value="0">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="amount[]" class="form-control form-control-sm rowAmount" readonly value="'+qty+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="local_rate[]" class="form-control form-control-sm local_rate" value="">'+
                                '</td>'+

                                '<td>'+
                                    '<input type="text" name="sell_rate[]" class="form-control form-control-sm rowSellRate" value="'+cihSellRate+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="fc_debit[]" class="form-control form-control-sm rowAmount" readonly value="0">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="fc_credit[]" class="form-control form-control-sm rowSellRate" value="'+qty+'">'+
                                '</td>'+

                                '<td>'+
                                    '<input type="text" name="debit[]" class="form-control form-control-sm rowDebit" readonly value="0">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="credit[]" class="form-control form-control-sm rowCredit" readonly value="'+amount+'">'+
                                '</td>'+
                                '<td>'+
                                    '<button type="button" disabled class="btn btn-warning btn-sm currencyRow">Edit</button>'+
                                '</td>'+
                            '</tr>';
                        tr += '<tr>'+
                            '<td>'+
                                '<input type="hidden" name="account_id[]" class="rowRecChartID" readonly value="'+pCurrencyChartId+'">'+
                                '<input type="text" name="account_code[]" class="form-control form-control-sm rowRecChartName" readonly value="'+pCurrencyChartName+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="desc[]" class="form-control form-control-sm" value="">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="qty[]" class="form-control form-control-sm rowQty" readonly value="'+amount+'">'+
                            '</td>'+
                            // '<td>'+
                            //     '<input type="hidden" readonly class="rowPaidChartId" value="'+pCurrencyChartId+'">'+
                            //     '<input type="text" class="form-control form-control-sm rowPaidChartName" readonly value="'+pCurrencyChartName+'">'+
                            // '</td>'+
                            '<td>'+
                                '<input type="text" name="amount[]" class="form-control form-control-sm rowAmount" readonly value="0">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="local_rate[]" class="form-control form-control-sm local_rate" value="">'+
                            '</td>'+

                            '<td>'+
                                '<input type="text" name="sell_rate[]" class="form-control form-control-sm rowSellRate" readonly value="1">'+
                            '</td>'+
                            '<td>'+
                                    '<input type="text" name="fc_debit[]" class="form-control form-control-sm rowAmount" readonly value="'+amount+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="fc_credit[]" class="form-control form-control-sm rowSellRate" value="0">'+
                                '</td>'+

                            '<td>'+
                                '<input type="text" name="debit[]" class="form-control form-control-sm rowDebit" readonly value="'+amount+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="credit[]" class="form-control form-control-sm rowCredit" readonly value="0">'+
                            '</td>'+
                            '<td>'+
                                '<button type="button" disabled class="btn btn-warning btn-sm currencyRow">Edit</button>'+
                            '</td>'+
                        '</tr>';
                        $('.egt_form_body').append(tr);
                        $('#buy_cash_chart_name').val('');
                        $('#buy_cash_chart_id').val('');

                        $('#cash_chart_name').val('');
                        $('#cash_chart_id').val('');

                        $('#quantity').val('');
                        $('#cih_sell_rate').val('');

                        var debit_sum = 0;
                        var credit_sum = 0;

                        $('.egt_form_table > tbody  > tr').each(function(index, tr) {

                            console.log(debit_sum);
                            debit_sum += parseFloat($(this).find(".rowDebit").val());
                            credit_sum += parseFloat($(this).find(".rowCredit").val());
                        });
                        // console.log(credit_sum);
                        $('#tot_debit').text(debit_sum);
                        $('#tot_credit').text(credit_sum);
                    }else{
                        ntoastr.error('Fields are empty...');
                    }

                }else{
                    if(rCurrencyChartName != null && pCurrencyChartName != null && qty != '' && cihSellRate != '' && amount != 'NaN' ){
                        var tr = '';

                        tr = '<tr>'+
                                '<td>'+
                                    '<input type="hidden" name="account_id[]" class="rowRecChartID" readonly value="'+rCurrencyChartId+'">'+
                                    '<input type="text" name="account_code[]" class="form-control form-control-sm rowRecChartName" readonly value="'+rCurrencyChartName+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="desc[]" class="form-control form-control-sm" value="">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="qty[]" class="form-control form-control-sm rowQty" readonly value="'+qty+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="amount[]" class="form-control form-control-sm rowAmount" readonly value="0">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="local_rate[]" class="form-control form-control-sm local_rate" value="">'+
                                '</td>'+

                                '<td>'+
                                    '<input type="text" name="sell_rate[]" class="form-control form-control-sm rowSellRate" value="'+cihSellRate+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="fc_debit[]" class="form-control form-control-sm rowAmount" readonly value="'+qty+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="fc_credit[]" class="form-control form-control-sm rowSellRate" value="0">'+
                                '</td>'+

                                '<td>'+
                                    '<input type="text" name="debit[]" class="form-control form-control-sm rowDebit" readonly value="'+amount+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" readonly name="credit[]" class="form-control form-control-sm rowCredit" readonly value="0">'+
                                '</td>'+
                                '<td>'+
                                    '<button type="button" disabled class="btn btn-warning btn-sm currencyRow">Edit</button>'+
                                '</td>'+
                            '</tr>';
                            tr += '<tr>'+
                                '<td>'+
                                    '<input type="hidden" name="account_id[]" class="rowRecChartID" readonly value="'+pCurrencyChartId+'">'+
                                    '<input type="text" name="account_code[]" class="form-control form-control-sm rowRecChartName" readonly value="'+pCurrencyChartName+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="desc[]" class="form-control form-control-sm" value="">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="qty[]" class="form-control form-control-sm rowQty" readonly value="0">'+
                                '</td>'+
                                // '<td>'+
                                //     '<input type="hidden" readonly class="rowPaidChartId" value="'+pCurrencyChartId+'">'+
                                //     '<input type="text" class="form-control form-control-sm rowPaidChartName" readonly value="'+pCurrencyChartName+'">'+
                                // '</td>'+
                                '<td>'+
                                    '<input type="text" name="amount[]" class="form-control form-control-sm rowAmount" readonly value="'+amount+'">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="local_rate[]" class="form-control form-control-sm local_rate" value="">'+
                                '</td>'+

                                '<td>'+
                                    '<input type="text" name="sell_rate[]" class="form-control form-control-sm rowSellRate" readonly value="1">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="fc_debit[]" class="form-control form-control-sm rowAmount" readonly value="0">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" name="fc_credit[]" class="form-control form-control-sm rowSellRate" value="'+amount+'">'+
                                '</td>'+

                                '<td>'+
                                    '<input type="text" name="debit[]" class="form-control form-control-sm rowDebit" readonly value="0">'+
                                '</td>'+
                                '<td>'+
                                    '<input type="text" readonly name="credit[]" class="form-control form-control-sm rowCredit" readonly value="'+amount+'">'+
                                '</td>'+
                                '<td>'+
                                    '<button type="button" disabled class="btn btn-warning btn-sm currencyRow">Edit</button>'+
                                '</td>'+
                            '</tr>';
                            $('.egt_form_body').append(tr);
                            $('#buy_cash_chart_name').val('');
                            $('#buy_cash_chart_id').val('');

                            $('#cash_chart_name').val('');
                            $('#cash_chart_id').val('');

                            $('#quantity').val('');
                            $('#cih_sell_rate').val('');

                            var debit_sum = 0;
                            var credit_sum = 0;

                            $('.egt_form_table > tbody  > tr').each(function(index, tr) {

                                console.log(debit_sum);
                                debit_sum += parseFloat($(this).find(".rowDebit").val());
                                credit_sum += parseFloat($(this).find(".rowCredit").val());
                            });
                            // console.log(credit_sum);
                            $('#tot_debit').text(debit_sum);
                            $('#tot_credit').text(credit_sum);
                    }else{
                        ntoastr.error('Fields are empty...');
                    }
                }
            }else{
                if(rCurrencyChartName != null && pCurrencyChartName != null && qty != '' && cihSellRate != '' && amount != 'NaN' ){
                    var tr = '';

                    tr = '<tr>'+
                            '<td>'+
                                '<input type="hidden" name="account_id[]" class="rowRecChartID" readonly value="'+rCurrencyChartId+'">'+
                                '<input type="text" name="account_code[]" class="form-control form-control-sm rowRecChartName" readonly value="'+rCurrencyChartName+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="desc[]" class="form-control form-control-sm" value="">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="qty[]" class="form-control form-control-sm rowQty" readonly value="0">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="amount[]" class="form-control form-control-sm rowAmount" readonly value="'+qty+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="local_rate[]" class="form-control form-control-sm local_rate" value="">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="sell_rate[]" class="form-control form-control-sm rowSellRate" value="'+cihSellRate+'">'+
                            '</td>'+

                            '<td>'+
                                '<input type="text" name="fc_debit[]" class="form-control form-control-sm rowAmount" readonly value="0">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="fc_credit[]" class="form-control form-control-sm rowSellRate" value="'+qty+'">'+
                            '</td>'+

                            '<td>'+
                                '<input type="text" name="debit[]" class="form-control form-control-sm rowDebit" readonly value="0">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="credit[]" class="form-control form-control-sm rowCredit" readonly value="'+amount+'">'+
                            '</td>'+
                            '<td>'+
                                '<button type="button" disabled class="btn btn-warning btn-sm currencyRow">Edit</button>'+
                            '</td>'+
                        '</tr>';
                        tr += '<tr>'+
                            '<td>'+
                                '<input type="hidden" name="account_id[]" class="rowRecChartID" readonly value="'+pCurrencyChartId+'">'+
                                '<input type="text" name="account_code[]" class="form-control form-control-sm rowRecChartName" readonly value="'+pCurrencyChartName+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="desc[]" class="form-control form-control-sm" value="">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="qty[]" class="form-control form-control-sm rowQty" readonly value="'+amount+'">'+
                            '</td>'+
                            // '<td>'+
                            //     '<input type="hidden" readonly class="rowPaidChartId" value="'+pCurrencyChartId+'">'+
                            //     '<input type="text" class="form-control form-control-sm rowPaidChartName" readonly value="'+pCurrencyChartName+'">'+
                            // '</td>'+
                            '<td>'+
                                '<input type="text" name="amount[]" class="form-control form-control-sm rowAmount" readonly value="0">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="local_rate[]" class="form-control form-control-sm local_rate" value="">'+
                            '</td>'+

                            '<td>'+
                                '<input type="text" name="sell_rate[]" class="form-control form-control-sm rowSellRate" readonly value="1">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="fc_debit[]" class="form-control form-control-sm rowAmount" readonly value="'+amount+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="fc_credit[]" class="form-control form-control-sm rowSellRate" value="0">'+
                            '</td>'+

                            '<td>'+
                                '<input type="text" name="debit[]" class="form-control form-control-sm rowDebit" readonly value="'+amount+'">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" name="credit[]" class="form-control form-control-sm rowCredit" readonly value="0">'+
                            '</td>'+
                            '<td>'+
                                '<button type="button" disabled class="btn btn-warning btn-sm currencyRow">Edit</button>'+
                            '</td>'+
                        '</tr>';
                        $('.egt_form_body').append(tr);
                        $('#buy_cash_chart_name').val('');
                        $('#buy_cash_chart_id').val('');

                        $('#cash_chart_name').val('');
                        $('#cash_chart_id').val('');

                        $('#quantity').val('');
                        $('#cih_sell_rate').val('');

                        var debit_sum = 0;
                        var credit_sum = 0;

                        $('.egt_form_table > tbody  > tr').each(function(index, tr) {

                            console.log(debit_sum);
                            debit_sum += parseFloat($(this).find(".rowDebit").val());
                            credit_sum += parseFloat($(this).find(".rowCredit").val());
                        });
                        // console.log(credit_sum);
                        $('#tot_debit').text(debit_sum);
                        $('#tot_credit').text(credit_sum);
                }else{
                    ntoastr.error('Fields are empty...');
                }
            }

                // console.log(tr);
        });

        $(document).on('click','.currencyRow',function(){
            var tr = $(this).closest('tr');

            var rowRecChartId = tr.find('.rowRecChartId').val();
            var rowRecChartName = tr.find('.rowRecChartName').val();
            $('#buy_cash_chart_id').val(rowRecChartId);
            $('#buy_cash_chart_name').val(rowRecChartName);

            var rowQty = tr.find('.rowQty').val();
            var rowSellRate = tr.find('.rowSellRate').val();
            $('#quantity').val(rowQty);
            $('#cih_sell_rate').val(rowSellRate);

            var rowPaidChartId = tr.find('.rowPaidChartId').val();
            var rowPaidChartName = tr.find('.rowPaidChartName').val();
            $('#cash_chart_name').val(rowPaidChartName);
            $('#cash_chart_id').val(rowPaidChartId);

            // var rowAmount = tr.find('.rowAmount').val();
            tr.remove();

        });
        $(document).on('click','.form_type',function(){
            var form_type = $(this).val();
            if(form_type == 'sell'){
                getCode(form_type);
                $('#buy_h6').text('Sell Currency');
                $('#paid_h6').text('Receive Currency');
                // $('.expense_amount').hide('Receive');


                hideShow();

                $('#customerRow').show();
                // $('.gain_row').show();
                $('#customerRow').show();

                $('.convert').show();
                $('.math_formula').show();
                $('#supplierRow').hide();
            }else if(form_type == 'buy'){
                getCode(form_type);
                hideShow();
                $('#buy_h6').text('Receive');
                $('#paid_h6').text('Paid');

                $('.gain_row').hide();
                $('#customerRow').hide();
                $('#supplierRow').show();
                $('.math_formula').hide();

                $('.convert').hide();

            }else{
                getCode(form_type);
                hideShow();
                $('#buy_h6').text('From Currency');
                $('#paid_h6').text('To Currency');
                $('.math_formula').show();

                $('#supplierRow').hide();
                $('#customerRow').hide();
                $('.convert').show();

                $('.gain_row').show();
            }
        });

        function hideShow(form_type){
                $('.transaction_save_btn').removeAttr('disabled');
                $('#buy_cash_chart_name').removeAttr('disabled');
                $('#quantity').removeAttr('disabled');
                $('.payment').removeAttr('disabled');
                $('#payment_type').removeAttr('disabled');
                $('#market_rate').removeAttr('disabled');
                $('#old_buying_amount').removeAttr('disabled');
                $('#cih_sell_rate').removeAttr('disabled');
                $('#gridAddBtn').removeAttr('disabled');

        }

        function getCode(form_type){
            var validate = true;
                if(validate){
                    var formData = {
                        form_type : form_type
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        url: '{{ route('ajax.getCode') }}' + '/' + form_type,
                        dataType	: 'json',
                        data        : form_type,
                        success: function(response) {
                            if(response.status == 'success'){
                                console.log(response.data.code);
                                var code = response.data.code;
                                $('form').find('#code').html('');
                                $('form').find('#code').html(code);
                            }else{
                                ntoastr.error(response.message);
                            }
                        },
                        error: function(response,status) {
                            ntoastr.error('server error..404');
                        }
                    });

                }
        }
        </script>

        <script src="{{asset('/pages/help/bank_currency_help.js')}}"></script>

        <script src="{{asset('/pages/help/cash_currency_help.js')}}"></script>

        <script src="{{asset('/pages/help/buy_cash_currency_help.js')}}"></script>
    @yield('scriptCustom')
@endsection
