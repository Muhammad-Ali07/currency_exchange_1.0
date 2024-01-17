@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @php
        $current = $data['current'];

        // dd($current);
        // if(!$data['view']){
        //     $url = route('purchase.product-property.update',$data['id']);
        // }
    @endphp
    @permission($data['permission'])
    <form id="product_quantity_edit" class="product_quantity_edit" action="{{route('master.product-quantity.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        {{-- @if(!$data['view']) --}}
            @csrf
            @method('patch')
        {{-- @endif --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            {{-- @if($data['view'])
                                @permission($data['permission_edit'])
                                <a href="{{route('purchase.product-property.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                @endpermission
                            @else --}}
                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
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
                                    <div class="col-md-6">
                                        <h5>{{$current->code}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-form-label p-0">Entry Date:</label>
                                <input type="text" id="entry_date" name="entry_date" class="form-control form-control-sm" value="{{date('d-m-Y', strtotime($current->entry_date))}}" />
                            </div>
                            {{-- <div class="col-sm-4">
                            </div> --}}
                            <div class="col-lg-6">
                                <label class="col-form-label p-0">Product<span class="required">*</span></label>
                                <div class="input-group eg_help_block">
                                    <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                    <input id="product_name" type="text" placeholder="Click here..." name="product_name" value="{{ $current->product->name }}" class="product_name form-control form-control-sm text-left">
                                    <input id="product_id" type="hidden" class="product_id" value="{{ $current->product_id }}" name="product_id">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label class="col-form-label p-0">Quantity<span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter Quantity" id="product_quantity" value="{{ $current->quantity }}" name="product_quantity" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label p-0">Buying Rate<span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter rate" value="{{ $current->buying_rate }}" id="buying_rate" name="buying_rate" />
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
    <script src="{{ asset('/pages/sale/product/edit.js') }}"></script>
@endsection

@section('script')
<script>
    var entry_date = $('#entry_date');
    if (entry_date.length) {
        entry_date.flatpickr({
            dateFormat: 'd-m-Y',
        });
    }
</script>
@endsection
