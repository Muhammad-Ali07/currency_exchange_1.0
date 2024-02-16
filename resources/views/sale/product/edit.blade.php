@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @php
        $current = $data['current'];
        // if(!$data['view']){
        //     $url = route('master.product.update',$data['id']);
        // }
    @endphp
    @permission($data['permission'])
    <form id="product_edit" class="product_edit" action="{{route('master.product.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                            {{-- @if($data['view']) --}}
                                {{-- @permission($data['permission_edit'])
                                <a href="{{route('purchase.product-property.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                @endpermission --}}
                            {{-- @else --}}
                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
                            {{-- @endif --}}
                        </div>
                        <div class="card-link">
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-1 row">
                                    <div class="col-md-6">
                                        <h5>{{$current->code}}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->name}}" id="name" name="name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Product Type </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="product_type" name="product_type">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['product_types'] as $product_types)
                                            <option value="{{$product_types}}" {{$product_types == $current->product_form_type ?"selected":""}} > {{$product_types}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Sign </label>
                                    </div>
                                    <div class="col-sm-8 mb-1">
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
                                            <a onclick="document.getElementById('product_showImage').src='{{ $img }}'" class="close AClass" id="product_resetInput">
                                                <span class="img_remove">&times;</span>
                                            </a>
                                            <img id="product_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float: {{session()->get('locale') == 'ar' ?"left":"right"}};">
                                        </div>
                                        <input class="form-control form-control-sm" type="file" value="{{ $img }}" id="product_image_url" name="om_image"/>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="status" name="status" {{$current->status == 1?"checked":""}}>
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
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/purchase/product/edit.js') }}"></script>
@endsection

@section('script')
<script>
    //Show image on change picture
    $(document).ready(function() {
        $('#product_image_url').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#product_showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
    //Reset Image on Cross Click
    $(document).ready(function() {
        $('#product_resetInput').on('click', function() {
            $('#product_image_url').val('');
        });
    });
</script>
@endsection
