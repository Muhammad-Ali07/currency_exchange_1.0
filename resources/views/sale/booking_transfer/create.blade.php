@extends('layouts.form')
@section('title', $data['title'])
@section('style')
<style>
    .new_member_and_nominee{
        padding-bottom:1px !important;
    }
    .transfer_process{
        padding-top:1px !important;
    }
    .txt_color{
        color: #0004f8;
    }
</style>
@endsection

@section('content')
@permission($data['permission'])
@php
    $entry_date = date('Y-m-d');
@endphp
<form id="booking_transfer_create" class="booking_transfer_create" action="{{route('sale.booking-transfer.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" id="form_type" value="booking_transfer">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-left-side">
                        <h4 class="card-title">{{$data['title']}}</h4>
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                    </div>
                </div>
                <div class="card-body mt-2 new_member_and_nominee">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>{{$data['code']}} </h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="col-form-label p-0">Entry Date: <span class="required">*</span></label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" id="entry_date" name="date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($entry_date))}}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label class="col-form-label p-0">Status:</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-12">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="booking_transfer_status" name="status" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>New Member Information</h3>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-12 mb-1">
                                <label class="col-form-label p-0">Customer  <span class="required">*</span></label>
                                <div class="input-group eg_help_block">
                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                    <input id="customer_name" type="text" name="nm_customer_name" class="customer_name nm_customer_name form-control form-control-sm text-left">
                                    <input id="customer_id" type="hidden" class="nm_customer_id" name="nm_customer_id">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Membership No#</label>
                                    <input type="hidden" class="form-control form-control-sm nm_membership_no" value="" id="nm_membership_no_input" name="nm_membership_no" />
                                    <p class="col-form-label nm_membership_no p-0 txt_color" id="nm_membership_no"></p>
                                </div>

                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Registration No#</label>
                                    <input type="hidden" class="form-control form-control-sm " value="" id="nm_registration_no_input" name="nm_registration_no" />
                                    <p class="col-form-label nm_registration_no p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">CNIC No#</label>
                                    <input type="hidden" class="form-control form-control-sm cnic" value="" id="nm_cnic_no_input" name="nm_cnic_no" />
                                    <p class="col-form-label nm_cnic_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Mobile No#</label>
                                    <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="" id="nm_mobile_no_input" name="nm_mobile_no" />
                                    <p class="col-form-label nm_mobile_no p-0 txt_color"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h3>Nominee Info</h3>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Nominee No#</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="nm_nominee_no_input" name="nm_nominee_no" />
                                    <p class="col-form-label nm_nominee_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Nominee Name</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="nm_nominee_name_input" name="nm_nominee_name" />
                                    <p class="col-form-label nm_nominee_name p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">S/O,W/O Name</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="nm_nominee_parent_name_input" name="nm_nominee_parent_name" />
                                    <p class="col-form-label nm_nominee_parent_name p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Relation With Client </label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="nm_nominee_relation_input" name="nm_nominee_relation" />
                                    <p class="col-form-label nm_nominee_relation_name p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Contact No#</label>
                                    <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="" id="nm_nominee_contact_no_input" name="nm_nominee_contact_no" />
                                    <p class="col-form-label nm_nominee_contact_no p-0 txt_color "></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">CNIC No# </label>
                                    <input type="hidden" class="form-control form-control-sm cnic" value="" id="nm_nominee_cnic_no" name="nm_nominee_cnic_no" />
                                    <p class="col-form-label nm_nominee_cnic_no p-0 txt_color"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-12 mb-1">
                                {{-- <label class="col-form-label">Avatar: </label> --}}
                                @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                                <style>
                                    .AClass {
                                        right: 100px;
                                        position: absolute;
                                        top: 77px;
                                        width: 1rem;
                                        font-size: larger;
                                        height: 1rem;
                                        background-color: crimson;
                                        border-radius: 20%;
                                    }
                                    .img_remove{
                                        position: absolute;
                                        top: -6px;
                                        left: 2px;
                                        color:white;
                                    }
                                </style>
                                <div style="position: relative;">
                                    <a onclick="document.getElementById('nm_showImage').src='{{ $img }}'" class="close AClass" id="nm_resetInput">
                                        <span class="img_remove">&times;</span>
                                    </a>
                                    <img id="nm_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float: {{session()->get('locale') == 'ar' ?"left":"right"}};">
                                </div>
                                <input class="form-control form-control-sm" type="file" value="{{ $img }}" id="nm_image_url" name="nm_image"/>
                            </div>

                        </div>
                    </div>{{--end row--}}
                </div>
                <hr>
                <div class="card-body transfer_process">
                    <h3>Transfer Process</h3>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-12 mb-1">
                                <label class="col-form-label p-0">Customer <span class="required">*</span></label>
                                <div class="input-group eg_help_block">
                                    <span class="input-group-text" id="om_addon_remove"><i data-feather='minus-circle'></i></span>
                                    <input id="om_customer_name" name="om_customer_name" type="text" class="om_customer_name form-control form-control-sm text-left">
                                    <input id="om_customer_id" type="hidden" class="om_customer_id" name="om_customer_id">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Membership No#</label>
                                    <input type="hidden" class="form-control form-control-sm om_membership_no" value="" id="om_membership_no_input" name="om_membership_no" />
                                    <p class="col-form-label om_membership_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">CNIC No#</label>
                                    <input type="hidden" class="form-control form-control-sm cnic" value="" id="om_cnic_no" name="om_cnic_no" />
                                    <p class="col-form-label om_cnic_no p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Registration No#</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_registration_no_input" name="om_registration_no" />
                                    <p class="col-form-label om_registration_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Mobile No#</label>
                                    <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="" id="om_mobile_no_input" name="om_mobile_no" />
                                    <p class="col-form-label om_mobile_no p-0 txt_color"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h3>Nominee Info</h3>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Nominee No#</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_nominee_no_input" name="om_nominee_no" />
                                    <p class="col-form-label om_nominee_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Nominee Name</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_nominee_name_input" name="om_nominee_name" />
                                    <p class="col-form-label om_nominee_name p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">S/O,W/O Name</label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_nominee_parent_name_input" name="om_nominee_parent_name" />
                                    <p class="col-form-label om_nominee_parent_name p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Relation With Client </label>
                                    <input type="hidden" class="form-control form-control-sm" value="" id="om_nominee_relation_input" name="om_nominee_relation" />
                                    <p class="col-form-label om_nominee_relation_name p-0 txt_color"></p>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">Contact No#</label>
                                    <input type="hidden" class="text-start form-control form-control-sm NumberValidate" value="" id="om_nominee_contact_no_input" name="om_nominee_contact_no" />
                                    <p class="col-form-label om_nominee_contact_no p-0 txt_color"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="col-form-label p-0">CNIC No# </label>
                                    <input type="hidden" class="form-control form-control-sm cnic" value="" id="om_nominee_cnic_no" name="om_nominee_cnic_no" />
                                    <p class="col-form-label om_nominee_cnic_no p-0 txt_color"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                            <style>
                                .AClass {
                                    right: 100px;
                                    position: absolute;
                                    top: 77px;
                                    width: 1rem;
                                    font-size: larger;
                                    height: 1rem;
                                    background-color: crimson;
                                    border-radius: 20%;
                                }
                                .img_remove{
                                    position: absolute;
                                    top: -6px;
                                    left: 2px;
                                    color:white;
                                }
                            </style>
                            <div style="position: relative;">
                                <a onclick="document.getElementById('om_showImage').src='{{ $img }}'" class="close AClass" id="om_resetInput">
                                    <span class="img_remove">&times;</span>
                                </a>
                                {{-- @dd($img); --}}
                                <img id="om_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float: {{session()->get('locale') == 'ar' ?"left":"right"}};">
                            </div>
                            <input class="form-control form-control-sm" type="file" id="om_image_url"  name="om_image"/>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body booking_list">
                    <div class="row">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <div class="mb-1 row">
                                    <div class="col-sm-12">
                                        <label class="col-form-label p-0">Booking List <span class="required">*</span></label>
                                        <select class="select2 form-select bookingList" id="booking_id" name="booking_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Booking Code</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_booking_code_input" name="booking_code" />
                                        <p class="col-form-label om_booking_code p-0 txt_color"></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">Product Name <span class="required">*</span></label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_product_name_input_id" name="product_id" />
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_product_name_input_name" name="product_name" />
                                        <p class="col-form-label om_product_name p-0 txt_color"></p>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label p-0">File Status</label>
                                        <input type="hidden" class="form-control form-control-sm" value="" id="om_file_status_input_id" name="file_status_id" />
                                        <p class="col-form-label om_file_status p-0 txt_color"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                    </div>{{--end row--}}
                </div>
            </div>
        </div>
    </div>
</form>
@endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/sale/booking_transfer/create.js') }}"></script>

@endsection

@section('script')
    <script src="{{ asset('/pages/help/customer_help.js')}}"></script>
    <script src="{{ asset('/pages/help/old_customer_help.js') }}"></script>
    <script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
    <script>
        $(".cnic").inputmask({
            'mask': '99999-9999999-9'
        });

        var entry_date = $('#entry_date');
        if (entry_date.length) {
            entry_date.flatpickr({
                dateFormat: 'd-m-Y',
            });
        }

        // get customer data new member
        $(document).on('focus','#customer_name',function(){
            // var thix = $(this);
            var customer_id = $('form').find('#customer_id').val();
            // console.log('test');
            funcGetNewMemberDetail(customer_id);
        });
        function funcGetNewMemberDetail(customer_id) {
            var validate = true;
            if(valueEmpty(customer_id)){
                // ntoastr.error("Select New Customer");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    customer_id : customer_id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.booking-transfer.getCustomerList') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var customer = response.data['customer'];
                            var length = customer.length;

                            $('form').find('.nm_membership_no').html(customer.membership_no);
                            $('form').find('#nm_membership_no_input').val(customer.membership_no);

                            $('form').find('.nm_registration_no').html(customer.registration_no);
                            $('form').find('#nm_registration_no_input').val(customer.registration_no);

                            $('form').find('.nm_cnic_no').html(customer.cnic_no);
                            $('form').find('#nm_cnic_no_input').val(customer.cnic_no);

                            $('form').find('.nm_mobile_no').html(customer.mobile_no);
                            $('form').find('#nm_mobile_no_input').val(customer.mobile_no);

                            $('form').find('.nm_nominee_no').html(customer.nominee_no);
                            $('form').find('#nm_nominee_no_input').val(customer.nominee_no);

                            $('form').find('.nm_nominee_name').html(customer.nominee_name);
                            $('form').find('#nm_nominee_name_input').val(customer.nominee_name);

                            $('form').find('.nm_nominee_parent_name').html(customer.nominee_father_name);
                            $('form').find('#nm_nominee_parent_name_input').val(customer.nominee_father_name);

                            $('form').find('.nm_nominee_contact_no').html(customer.nominee_contact_no);
                            $('form').find('#nm_nominee_contact_no_input').val(customer.nominee_contact_no);

                            $('form').find('.nm_nominee_cnic_no').html(customer.nominee_cnic_no);
                            $('form').find('#nm_nominee_cnic_no').val(customer.nominee_cnic_no);

                            $('form').find('.nm_nominee_relation_name').html(customer.nominee_relation);
                            $('form').find('#nm_nominee_relation_input').val(customer.nominee_relation);
                            // $('.nm_customer_name').focusout();
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

        //remove customer in new member
        $(document).on('click','#addon_remove',function(){
            $('form').find('.nm_customer_id').val('');

            $('form').find('.nm_membership_no').html('');
            $('form').find('#nm_membership_no_input').val('');

            $('form').find('.nm_registration_no').html('');
            $('form').find('#nm_registration_no_input').val('');

            $('form').find('.nm_cnic_no').html('');
            $('form').find('#nm_cnic_no_input').val('');

            $('form').find('.nm_mobile_no').html('');
            $('form').find('#nm_mobile_no_input').val('');

            $('form').find('.nm_nominee_no').html('');
            $('form').find('#nm_nominee_no_input').val('');

            $('form').find('.nm_nominee_name').html('');
            $('form').find('#nm_nominee_name_input').val('');

            $('form').find('.nm_nominee_parent_name').html('');
            $('form').find('#nm_nominee_parent_name_input').val('');

            $('form').find('.nm_nominee_contact_no').html('');
            $('form').find('#nm_nominee_contact_no_input').val('');

            $('form').find('.nm_nominee_cnic_no').html('');
            $('form').find('#nm_nominee_cnic_no').val('');

            $('form').find('.nm_nominee_relation_name').html('');
            $('form').find('#nm_nominee_relation_input').val('');

        });

        // get customer data old member
        $(document).on('focus','#om_customer_name',function(){
            // var thix = $(this);
            var customer_id = $('form').find('#om_customer_id').val();
            // console.log('test');
            funcGetOldMemberDetail(customer_id);
        });
        function funcGetOldMemberDetail(customer_id) {
            var validate = true;
            if(valueEmpty(customer_id)){
                // ntoastr.error("Select New Customer");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    customer_id : customer_id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.booking-transfer.getCustomerList') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var customer = response.data['customer'];
                            var sales = response.data['customer'].sales;
                            var options = "<option value='0' selected>Select</option>";
                            var length = customer.length;
                            var sales_length = customer.sales.length;

                            // console.log(customer.sales[0]['code']);
                            for(var i=0;i<sales_length;i++){
                                if(customer.sales[i]['code']){
                                    options += '<option value="'+customer.sales[i]['id']+'">'+customer.sales[i]['code']+'</option>';
                                }
                            }
                            $('form').find('.bookingList').html(options);

                            $('form').find('.om_membership_no').html(customer.membership_no);
                            $('form').find('#om_membership_no_input').val(customer.membership_no);

                            $('form').find('.om_registration_no').html(customer.registration_no);
                            $('form').find('#om_registration_no_input').val(customer.registration_no);

                            $('form').find('.om_cnic_no').html(customer.cnic_no);
                            $('form').find('#om_cnic_no').val(customer.cnic_no);

                            $('form').find('.om_mobile_no').html(customer.mobile_no);
                            $('form').find('#om_mobile_no_input').val(customer.mobile_no);

                            $('form').find('.om_booking_code').html('');
                            $('form').find('#om_booking_id_input').val('');
                            $('form').find('#om_booking_code_input').val('');

                            $('form').find('.om_product_name').html('');
                            $('form').find('#om_product_name_input_id').val('');
                            $('form').find('#om_product_name_input_name').val('');

                            $('form').find('.om_file_status').html('');
                            $('form').find('#om_file_status_input_id').val('');

                            $('form').find('.om_nominee_no').html(customer.nominee_no);
                            $('form').find('#om_nominee_no_input').val(customer.nominee_no);

                            $('form').find('.om_nominee_name').html(customer.nominee_name);
                            $('form').find('#om_nominee_name_input').val(customer.nominee_name);

                            $('form').find('.om_nominee_parent_name').html(customer.nominee_father_name);
                            $('form').find('#om_nominee_parent_name_input').val(customer.nominee_father_name);

                            $('form').find('.om_nominee_contact_no').html(customer.nominee_contact_no);
                            $('form').find('#om_nominee_contact_no_input').val(customer.nominee_contact_no);

                            $('form').find('.om_nominee_cnic_no').html(customer.nominee_cnic_no);
                            $('form').find('#om_nominee_cnic_no').val(customer.nominee_cnic_no);

                            $('form').find('.om_nominee_relation_name').html(customer.nominee_relation);
                            $('form').find('#om_nominee_relation_input').val(customer.nominee_relation);



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

        //remove customer in old member
        $(document).on('click','#om_addon_remove',function(){
            $('form').find('.om_customer_id').val('');

            $('form').find('.om_membership_no').html('');
            $('form').find('#om_membership_no_input').val('');

            $('form').find('.om_registration_no').html('');
            $('form').find('#om_registration_no_input').val('');

            $('form').find('.om_cnic_no').html('');
            $('form').find('#om_cnic_no_input').val('');

            $('form').find('.om_mobile_no').html('');
            $('form').find('#om_mobile_no_input').val('');

            $('form').find('.om_nominee_no').html('');
            $('form').find('#om_nominee_no_input').val('');

            $('form').find('.om_nominee_name').html('');
            $('form').find('#om_nominee_name_input').val('');

            $('form').find('.om_nominee_parent_name').html('');
            $('form').find('#om_nominee_parent_name_input').val('');

            $('form').find('.om_nominee_contact_no').html('');
            $('form').find('#om_nominee_contact_no_input').val('');

            $('form').find('.om_nominee_cnic_no').html('');
            $('form').find('#om_nominee_cnic_no').val('');

            $('form').find('.om_nominee_relation_name').html('');
            $('form').find('#om_nominee_relation_input').val('');

            $('form').find('#booking_id').html('');

            $('form').find('.om_booking_code').html('');
            $('form').find('#om_booking_code_input').val('');

            $('form').find('.om_product_name').html('');
            $('form').find('#om_product_name_input').val('');

            $('form').find('.om_file_status').html('');
            $('form').find('#om_file_status_input').val('');

        });

        //Booking Data
        $(document).on('change','#booking_id',function(){
            var validate = true;
            var thix = $(this);
            var val = thix.find('option:selected').val();
            if(valueEmpty(val)){
                ntoastr.error("Select New Booking");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    sale_id : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('sale.booking-transfer.getBookingDtl') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var sales = response.data['sales'];
                            var length = sales.length;

                            $('form').find('.om_booking_code').html(sales.code);
                            $('form').find('#om_booking_id_input').val(sales.id);
                            $('form').find('#om_booking_code_input').val(sales.code);

                            $('form').find('.om_product_name').html(sales.product.name);
                            $('form').find('#om_product_name_input_id').val(sales.product.id);
                            $('form').find('#om_product_name_input_name').val(sales.product.name);

                            $('form').find('.om_file_status').html(sales.file_status.name);
                            $('form').find('#om_file_status_input_id').val(sales.file_status.id);

                        }else{
                            ntoastr.error(response.message);
                        }
                    },
                    error: function(response,status) {
                        ntoastr.error('server error..404');
                    }
                });
            }
        });
    </script>
    <script>
        //Reset Image on Cross Click
        $(document).ready(function() {
            $('#nm_resetInput').on('click', function() {
                $('#nm_image_url').val('');
            });
        });
        //Reset Image on Cross Click
        $(document).ready(function() {
            $('#om_resetInput').on('click', function() {
                $('#om_image_url').val('');
            });
        });

    </script>
    <script type="text/javascript">
        //Show image on change picture
        $(document).ready(function() {
            $('#nm_image_url').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#nm_showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
        //Show image on change picture
        $(document).ready(function() {
            $('#om_image_url').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#om_showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

    </script>
@endsection

