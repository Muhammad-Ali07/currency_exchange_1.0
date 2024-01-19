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
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                        </div>
                        <div class="card-link">
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <b>{{$data['code']}}</b>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">Entry Date</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="entry_date" name="entry_date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($entry_date))}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">Type <span class="required">*</span></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group eg_help_block">
                                                <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                <input id="transaction_type" name="transaction_type" type="text" placeholder="Click here..." class="transaction_type form-control form-control-sm text-left">
                                                {{-- <input id="transaction_type_id" type="hidden" name="transaction_type_id"> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">Product <span class="required">*</span></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group eg_help_block">
                                                <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                <input id="product_name" type="text" placeholder="Click here..." class="product_name form-control form-control-sm text-left">
                                                <input id="product_id" type="hidden" name="product_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
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
                            </div>
                            <div class="mb-1 row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">Price</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm" id="sale_price" name="sale_price" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">Quantity</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm" id="quantity" name="quantity" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">Amount</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm" id="amount" name="amount" aria-invalid="false">
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
      </script>
      <script>
        $(document).on('keyup','#quantity',function(){
            var qty = $('#quantity').val();
            var price = $('#sale_price').val();
            var amount = 0;
            console.log(qty);
            amount = qty * price;
            console.log(amount);
            $('#amount').val(amount);
        });
      </script>
    @yield('scriptCustom')
@endsection
