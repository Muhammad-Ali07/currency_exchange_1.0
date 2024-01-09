@extends('layouts.form')
@section('title', $data['title'])
@section('style')
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
    @permission($data['permission'])
    <form id="sale_invoice_create" class="sale_invoice_create" action="{{route('sale.sale-invoice.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <b>{{$data['code']}}</b>
                                    </div>
                                </div>{{--
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Project <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="project_id" name="project_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['project'] as $project)
                                                <option value="{{$project->id}}"> {{$project->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>--}}
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Product <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group eg_help_block">
                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                            <input id="product_name" type="text" class="product_name form-control form-control-sm text-left">
                                            <input id="product_id" type="hidden" name="product_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Customer <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group eg_help_block">
                                            <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                            <input id="customer_name" type="text" class="customer_name form-control form-control-sm text-left">
                                            <input id="customer_id" type="hidden" name="customer_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller Type <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="seller_type" name="seller_type">
                                            <option value="0" selected>Select</option>
                                            <option value="dealer">Dealer</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Seller <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select sellerList" id="seller_id" name="seller_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3 pr-0">
                                        <label class="col-form-label p-0">File Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="file_status_id" name="file_status_id">
                                            @foreach($data['file_status'] as $file_status)
                                                <option value="{{$file_status->id}}" data-slug="{{$file_status->slug}}"> {{$file_status->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3 pr-0">
                                        <label class="col-form-label p-0">Payment Mode</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="property_payment_mode_id" name="property_payment_mode_id">
                                            @foreach($data['property_payment_mode'] as $property_payment_mode)
                                                <option value="{{$property_payment_mode->id}}" data-slug="{{$property_payment_mode->slug}}"> {{$property_payment_mode->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Sale Price</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="" class="form-control form-control-sm" id="sale_price" name="sale_price" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label p-0">Sale Discount</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="sale_discount" name="sale_discount">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Booking Price</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="booked_price" name="booked_price" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3 pr-0">
                                        <label class="col-form-label p-0">Down Payment</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="down_payment" name="down_payment" aria-invalid="false">
                                    </div>
                                </div>
                                <div id="installments_block" style="display: none">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label p-0">On Balloting</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm FloatValidate" id="on_balloting" name="on_balloting" aria-invalid="false">
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6 pr-0">
                                                    <label class="col-form-label p-0">No. Of Bi-Annual</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="no_of_bi_annual" name="no_of_bi_annual" aria-invalid="false">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Installments</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="installment_bi_annual" name="installment_bi_annual" aria-invalid="false"> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-form-label p-0">No. of Month</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="no_of_month" name="no_of_month" aria-invalid="false"> </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-form-label">Installments</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-sm FloatValidate" id="installment_amount_monthly" name="installment_amount_monthly" aria-invalid="false"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">On Possession</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm FloatValidate" id="on_possession" name="on_possession" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label p-0">Currency Note No.</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" id="currency_note_no" name="currency_note_no">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade right" id="createNewCustomer" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" style="display: none;" aria-hidden="true">
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
    </div>
    @endpermission
@endsection

@section('pageJs')
    <script>
        var current_project_id = '{{auth()->user()->project_id}}'
    </script>
    <script src="{{ asset('/pages/sale/sale_invoice/create.js') }}"></script>
    @yield('pageJsScript')
@endsection

@section('script')
    <script src="{{asset('/pages/help/customer_help.js')}}"></script>
    <script src="{{asset('/pages/help/product_help.js')}}"></script>
    <script>
        $(document).on('change','#seller_type',function(){
            var validate = true;
            var thix = $(this);
            var val = thix.find('option:selected').val();
            if(valueEmpty(val)){
                ntoastr.error("Select Seller Type");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    seller_type : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.sale-invoice.getSellerList') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var seller = response.data['seller'];
                            var length = seller.length;
                            var options = "<option value='0' selected>Select</option>";
                            for(var i=0;i<length;i++){
                                if(seller[i]['name']){
                                    options += '<option value="'+seller[i]['id']+'">'+seller[i]['name']+'</option>';
                                }
                            }
                            $('form').find('.sellerList').html(options);
                        }else{
                            ntoastr.error(response.message);
                        }
                    },
                    error: function(response,status) {
                        ntoastr.error('server error..404');
                    }
                });
            }
        })

        $(document).on('change','#project_id',function(){
            $('form').find('#product_name').val("");
            $('form').find('#product_id').val("");
        })
        $(document).on('change','#property_payment_mode_id',function(){
           var slug = $(this).find('option:selected').attr('data-slug');
            $('#installments_block').hide();
            $('#installments_block').find('input').val("");
           if(slug == 'installment'){
                $('#installments_block').show()
           }
        })
        var slug = $('#property_payment_mode_id').find('option:selected').attr('data-slug');
        if(slug == 'installment'){
            $('#installments_block').show();
        }
    </script>

    @yield('scriptCustom')
@endsection
