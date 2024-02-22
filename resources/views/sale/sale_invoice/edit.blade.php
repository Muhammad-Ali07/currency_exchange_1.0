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
    </style>
@endsection

@section('content')
    @php
        $current = $data['current'];
        // dd($current);
        $url = route('transaction.sale.update',$data['id']);

    @endphp
    @permission($data['permission'])
    <form id="sale_invoice_edit" class="sale_invoice_edit" action="{{isset($url)?$url:""}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            {{-- @if($data['view'])
                                @permission($data['permission_edit'])
                                <a href="{{route('sale.sale-invoice.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                @endpermission
                            @else --}}
                                <button type="submit" disabled class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
                            {{-- @endif --}}
                        </div>
                        <div class="card-link">
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <h4><b>{{$current->code}}</b></h4>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Entry Date</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" id="entry_date" name="entry_date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($current->entry_date))}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($current->customer_id))
                                    <div class="mb-1 row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">Customer <span class="required">*</span></label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="input-group eg_help_block">
                                                        <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                        <input id="customer_name" type="text" value="{{ $current->customer->name }}" placeholder="Click here..." class="customer_name form-control form-control-sm text-left">
                                                        <input id="customer_id" type="hidden" name="customer_id" value="{{ $current->customer->id }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                <div class="mb-1 row" id="supplierRow">
                                    <div class="col-lg-3">
                                        <label class="col-form-label p-0">Supplier<span class="required">*</span></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="input-group eg_help_block">
                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                            <input id="supplier_name" type="text" value="{{ $current->supplier->name }}" placeholder="Click here..." name="supplier_name" class="supplier_name form-control form-control-sm text-left">
                                            <input id="supplier_id" type="hidden" class="supplier_id" value="{{ $current->supplier->id }}" name="supplier_id">
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                                <div class="row"> <div class="col-lg-12 mb-2"></div></div>

                                <div class="card card-payment">
                                    {{-- <div class="card-header">
                                        <h4 class="card-title">Amount to be Paid</h4>
                                        <h4 class="card-title text-primary" id="amount">$0.00</h4>
                                    </div> --}}
                                    <div class="card-body">
                                        <form action="javascript:void(0);" class="form">
                                            <div class="row">
                                                {{-- <div class="col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="payment-card-number">Card Number</label>
                                                        <input type="number" id="payment-card-number" class="form-control" placeholder="2133 3244 4567 8921">
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="col-sm-6 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="payment-expiry">Payment Type</label>
                                                        <select class="select2 form-select" id="payment_type" name="payment_type">
                                                            <option value="cash" {{ ($sale->id == $current->booking_id )? "Selected":""  }} selected>Cash</option>
                                                            <option value="bank" selected>Bank</option>
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="col-sm-6 col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="payment-cvv">CVV / CVC</label>
                                                        <input type="number" id="payment-cvv" class="form-control" placeholder="123">
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="col-12">
                                                    <div class="mb-2">
                                                        <label class="form-label" for="payment-input-name">Input Name</label>
                                                        <input type="text" id="payment-input-name" class="form-control" placeholder="Curtis Stone">
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="d-grid col-12">
                                                    <button type="button" class="btn btn-primary waves-effect waves-float waves-light">Make Payment</button>
                                                </div> --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <div class="data_entry_header">
                                        <div class="hiddenFiledsCount" style="display: inline-block;"><span>0</span> fields hide</div>
                                        {{-- <div style="display: inline-block;">
                                            <a class="btn btn-sm btn-primary" id="gridAddBtn">Add</a>
                                        </div> --}}
                                        <div class="dropdown chart-dropdown" style="display: inline-block;">
                                            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                            @php
                                                $headings = ['Account Code','Received','Paid','Exchange Rate','Debit(LC)','Credit(LC)',];
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
                                                    @php
                                                        $debit_sum = 0;
                                                        $credit_sum = 0;
                                                    @endphp
                                                    <thead class="egt_form_header">
                                                    <tr class="egt_form_header_title">
                                                        <th width="20%">Account Code</th>
                                                        <th width="20%">Description</th>

                                                        <th width="22%">Received</th>
                                                        <th width="22%">Paid</th>
                                                        <th width="22%">Exchange Rate</th>
                                                        {{-- <th width="20%">Paid Currency Code</th> --}}
                                                        <th width="22%">Debit(LC)</th>
                                                        <th width="22%">Credit(LC)</th>
                                                        <th width="13%" class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="egt_form_body">
                                                        @if(isset( $data['current']->dtl) && count( $data['current']->dtl) > 0)
                                                        @foreach($data['current']->dtl as $dtl)
                                                            @if($dtl->customer_id == null)
                                                                <tr>
                                                                    {{-- <td class="handle"><i data-feather="move" class="handle egt_handle"></i>
                                                                        <input type="text" data-id="egt_sr_no" name="pd[{{$loop->iteration}}][egt_sr_no]"  value="{{$loop->iteration}}" class="form-control form-control-sm" readonly>
                                                                    </td> --}}
                                                                    <td>
                                                                        <input type="hidden" data-id="chart_id" name="pd[{{$loop->iteration}}][chart_id]" value="{{$dtl->account_id}}" class="chart_id form-control form-control-sm">
                                                                        <input type="hidden" data-id="egt_chart_code" name="pd[{{$loop->iteration}}][egt_chart_code]" value="{{$dtl->account_code}}" class=" chart_code form-control form-control-sm text-left" readonly>
                                                                        <input type="text" data-id="egt_chart_name" name="pd[{{$loop->iteration}}][egt_chart_name]" value="{{$dtl->account_name}}" class="chart_name form-control form-control-sm" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input id="egt_description" readonly type="text" name="pd[{{$loop->iteration}}][egt_description]" value="{{$dtl->description}}" class="description form-control form-control-sm">
                                                                    </td>

                                                                    <td>
                                                                        <input id="egt_received_fc" readonly type="text" name="pd[{{$loop->iteration}}][egt_received_fc]" value="{{$dtl->received_fc}}" class="received_fc form-control form-control-sm">
                                                                    </td>
                                                                    <td>
                                                                        <input id="egt_paid_fc" readonly type="text" name="pd[{{$loop->iteration}}][egt_paid_fc]" value="{{$dtl->paid_fc}}" class="paid_fc form-control form-control-sm">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" readonly data-id="egt_exchange_rate" name="pd[{{$loop->iteration}}][egt_exchange_rate]" value="{{$dtl->exchange_rate}}"  class="form-control form-control-sm">
                                                                    </td>
                                                                    <td>
                                                                        <input data-id="egt_debit" readonly type="text" name="pd[{{$loop->iteration}}][egt_debit]" value="{{number_format($dtl->debit,3)}}" class="FloatValidate debit form-control form-control-sm">
                                                                    </td>

                                                                    <td>
                                                                        <input data-id="egt_credit" readonly type="text" name="pd[{{$loop->iteration}}][egt_credit]" value="{{number_format($dtl->credit,3)}}" class="FloatValidate credit form-control form-control-sm">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="egt_btn-group">
                                                                            <button type="button" disabled class="btn btn-danger btn-sm egt_del">
                                                                                <i data-feather="trash-2"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $debit_sum += $dtl->debit;
                                                                    $credit_sum += $dtl->credit;

                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    </tbody>
                                                    <tfoot class="egt_form_footer">
                                                    <tr class="egt_form_footer_total">
                                                        <td class="voucher-total-title">Total</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="voucher-total-debit text-end">
                                                            <span id="tot_debit">{{ number_format($debit_sum,3) }}</span>
                                                            <input id="tot_voucher_debit" name="tot_voucher_debit" type="hidden" >
                                                        </td>
                                                        <td class="voucher-total-credit text-end">
                                                            <span id="tot_credit"> {{ number_format($credit_sum,3) }}</span>
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
                                            <textarea disabled name="remarks" class="form-control form-control-sm" id="summernote" >{!! $current->description !!}</textarea>
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
    <script>
        var current_project_id = '{{auth()->user()->project_id}}'
    </script>
    <script src="{{ asset('/pages/sale/sale_invoice/edit.js') }}"></script>
    @yield('pageJsScript')
@endsection

@section('script')
    <script src="{{asset('/pages/help/customer_help.js')}}"></script>
    <script src="{{ asset('/pages/help/supplier_help.js')}}"></script>

    <script src="{{asset('/pages/help/product_help.js')}}"></script>
    <script src="{{asset('/pages/help/transaction_type_help.js')}}"></script>
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
      $('#summernote').summernote('disable');
    </script>

    @yield('scriptCustom')
@endsection
