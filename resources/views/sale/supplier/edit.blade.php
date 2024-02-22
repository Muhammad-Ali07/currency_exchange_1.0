@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        // if(!$data['view']){
            $url = route('master.supplier.update',$data['id']);
        // }
    @endphp
    <form id="supplier_edit" class="supplier_edit" action="{{isset($url)?$url:""}}"  method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('purchase.supplier.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                            <div class="mb-1 row">
                                <div class="col-md-6">
                                    <h5>{{$current->code}} </h5>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{ $current->name }}" id="name" name="name" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label p-0">S/O,W/O Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{ $current->father_name }}" id="father_name" name="father_name" />
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
                                        <input type="text" class="text-start form-control form-control-sm NumberValidate" value="{{ $current->contact_no }}" id="contact_no" name="contact_no" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Mobile No#</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="text-start form-control form-control-sm NumberValidate" value="{{ $current->mobile_no }}" id="mobile_no" name="mobile_no" />
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
                                        <input type="text" class="form-control form-control-sm" value="{{ $current->email }}" id="email" name="email" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Passport No# <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{ $current->document_no }}" id="document_no" name="document_no" />
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
                                            <input type="text" class="form-control form-control-sm" id="address" name="address" value="{{ $current->address }}">
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
                                            <input type="checkbox" class="form-check-input" id="status" name="status" {{$current->status == 1?"checked":""}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Attachment</label>
                                    </div>
                                    <div class="col-sm-9">
                                        @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = isset($current->image) ? $current->image : '';@endphp
                                        @if(isset($image_url) && !is_null( $image_url ) && $image_url != "")
                                            @php $img = $root.'/uploads/'.$image_url; @endphp
                                        @else
                                            @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                                        @endif
                                        <a href="{{ asset($image_url) }}">Download</a>

                                        {{-- <img id="om_showImage" class="mb-1 float-end" src="{{ $img }}" style="width: 30%; height: 50%;"> --}}
                                        <input class="form-control form-control-sm" type="file"  id="om_image_url" name="om_image"/>
                                        <input type="hidden" value="{{ $image_url }}" name="om_hidden_image" id="om_hidden_avatar">
                                        <input type="hidden" value="{{ $current->image }}" name="om_hidden_image_upload_id" id="om_hidden_image_upload_id">
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
                                        <textarea class="form-control form-control-sm" rows="3" name="remarks" id="remarks">{{ $current->remarks }}</textarea>
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
    <script src="{{ asset('/pages/purchase/supplier/edit.js') }}"></script>
@endsection

@section('script')

@endsection
