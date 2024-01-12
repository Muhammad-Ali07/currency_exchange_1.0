@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
    @endphp
    <form id="company_edit" class="company_edit" action="{{route('setting.company.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
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
                                        <input type="text" class="form-control form-control-sm" value="{{$current->name}}" id="name" name="name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Contact No# </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->contact_no}}" id="contact_no" name="contact_no" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {{-- <div class="col-sm-4"> --}}
                                <div class="col-sm-12 mb-1">
                                    @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = $current->company_image;@endphp
                                    @if(isset($image_url) && !is_null( $image_url ) && $image_url != "")
                                        @php $img = $root.'/uploads/'.$image_url; @endphp
                                    @else
                                        @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                                    @endif
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
                                        {{-- @dd($img) --}}
                                        <a onclick="document.getElementById('company_image_showImage').src='{{ $img }}'" class="close AClass" id="company_image_resetInput">
                                            <span class="img_remove">&times;</span>
                                        </a>
                                        <img id="company_image_showImage" class="mb-1" src="{{ $img }}" style="width: 100px; height: 90px; float:right;">
                                    </div>
                                    <input class="form-control form-control-sm" type="file"  id="company_image_image_url" name="company_image_image"/>
                                    <input type="hidden" value="{{ $image_url }}" name="company_image_hidden_image" id="company_image_hidden_avatar">
                                </div>
                            </div>
                                {{-- @include('partials.address') --}}
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
    <script src="{{ asset('/pages/setting/company/edit.js') }}"></script>
@endsection

@section('script')
<script>
    //Reset Image on Cross Click
    $(document).ready(function() {
        $('#company_image_resetInput').on('click', function() {
            var src = "{{ asset('assets/images/avatars/blank-img.png') }}";
            $('#company_image_image_url').val('');
            $('#company_image_showImage').attr('src', src );
            $('#company_image_hidden_avatar').val('');
        });
    });
    //Show image on change picture
    $(document).ready(function() {
            $('#company_image_image_url').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#company_image_showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });

</script>
@endsection
