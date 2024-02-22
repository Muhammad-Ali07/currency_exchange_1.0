@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="supplier_create" class="supplier_create" action="{{route('master.supplier.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <div class="col-md-6">
                                    <h5>{{$data['code']}} </h5>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="name" name="name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label p-0">S/O,W/O Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="father_name" name="father_name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Contact No#</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="text-start form-control form-control-sm NumberValidate" value="" id="contact_no" name="contact_no" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Mobile No#</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="text-start form-control form-control-sm NumberValidate" value="" id="mobile_no" name="mobile_no" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Email</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="email" name="email" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Passport No# <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="document_no" name="document_no" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="col-sm-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">Address <span class="required">*</span></label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-sm" id="address" name="address" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="status" name="status" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Registration No.</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="registration_no" name="registration_no" />
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Attachment</label>
                                    </div>
                                    <div class="col-sm-9">
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
                                        {{-- <div style="position: relative;">
                                            <a onclick="document.getElementById('om_showImage').src='{{ $img }}'" class="close AClass" id="om_resetInput">
                                                <span class="img_remove">&times;</span>
                                            </a>
                                            <img id="om_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float: {{session()->get('locale') == 'ar' ?"left":"right"}};">
                                        </div> --}}
                                        <input class="form-control form-control-sm" type="file" id="om_image_url"  name="om_image"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {{-- <div class="mb-1 row"> --}}
                                    {{-- <div class="col-sm-2"> --}}
                                        {{-- <label class="col-form-label">Registration No.</label> --}}
                                        <label class="col-form-label">Remarks:</label>
                                    {{-- </div> --}}
                                    {{-- <div class="col-sm-10"> --}}
                                        <textarea class="form-control form-control-sm" rows="3" name="remarks" id="remarks"></textarea>
                                    {{-- </div> --}}
                                {{-- </div> --}}
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
    <script src="{{ asset('/pages/purchase/supplier/create.js') }}"></script>
@endsection

@section('script')

@endsection
