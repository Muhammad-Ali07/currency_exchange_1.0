@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $entry_date = date('Y-m-d');
    @endphp
    <form id="product_create" class="product_create" action="{{route('master.product-quantity.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                        <div class="mb-1 row">
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-md-6">
                                        <h5>{{$data['code']}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 row">
                            <div class="col-sm-6">
                                <label class="col-form-label p-0">Entry Date:</label>
                                <input type="text" id="entry_date" name="date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($entry_date))}}" />
                            </div>
                            {{-- <div class="col-sm-4">
                            </div> --}}
                        </div>
                        <div class="mb-1 row">
                            <div class="col-lg-6">
                                <label class="col-form-label p-0">Supplier<span class="required">*</span></label>
                                <div class="input-group eg_help_block">
                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                    <input id="supplier_name" type="text" placeholder="Click here..." name="supplier_name" class="supplier_name form-control form-control-sm text-left">
                                    <input id="supplier_id" type="hidden" class="supplier_id" name="supplier_id">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label p-0">Product<span class="required">*</span></label>
                                <div class="input-group eg_help_block">
                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                    <input id="product_name" type="text" placeholder="Click here..." name="product_name" class="product_name form-control form-control-sm text-left">
                                    <input id="product_id" type="hidden" class="product_id" name="product_id">
                                </div>
                            </div>

                        </div>
                        <div class="mb-1 row">
                            <div class="col-lg-6">
                                <label class="col-form-label p-0">Quantity<span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter Quantity" id="product_quantity" name="product_quantity" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label p-0">Buying Rate<span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter rate" id="buying_rate" name="buying_rate" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/sale/product/create.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('/pages/help/product_help.js')}}"></script>
    <script src="{{ asset('/pages/help/supplier_help.js')}}"></script>

    <script>
        var entry_date = $('#entry_date');
        if (entry_date.length) {
            entry_date.flatpickr({
                dateFormat: 'd-m-Y',
            });
        }
    </script>
@endsection
