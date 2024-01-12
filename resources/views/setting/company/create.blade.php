@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="company_create" class="company_create" action="{{route('setting.company.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                        <label class="col-form-label">Contact No# </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="contact_no" name="contact_no" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Address </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="address" name="address" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                                    <a onclick="document.getElementById('company_showImage').src='{{ $img }}'" class="close AClass" id="company_resetInput">
                                        <span class="img_remove">&times;</span>
                                    </a>
                                    <img id="company_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float: {{session()->get('locale') == 'ar' ?"left":"right"}};">
                                </div>
                                <input class="form-control form-control-sm" type="file" value="{{ $img }}" id="company_image_url" name="company_image"/>
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
<script type="text/javascript" src="{{ asset('pages/setting/company/create.js') }}"></script>
@endsection

@section('script')

    <script>
        //Show image on change picture
        $(document).ready(function() {
            $('#company_image_url').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#company_showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
        //Reset Image on Cross Click
        $(document).ready(function() {
            $('#company_resetInput').on('click', function() {
                $('#company_image_url').val('');
            });
        });
    </script>

@endsection
