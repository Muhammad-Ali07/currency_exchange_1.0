@permission($data['permission'])
<form id="customer_create" class="customer_create" action="{{route('master.customer.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                        <script> var modal = true; </script>
                        @if(isset($modal))
                            <script> var modal = true; </script>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: 0;"></button>
                        @else
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        @endif
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
                                    <label class="col-form-label">CNIC No# <span class="required">*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm cnic" value="" id="cnic_no" name="cnic_no" />
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
                    </div>
                    {{--end row--}}
                    {{-- <h3>Nominee Info</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Nominee No.</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" value="" id="nominee_no" name="nominee_no" />
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label p-0">Nominee Name</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" value="" id="nominee_name" name="nominee_name" />
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label p-0">S/O,W/O Name</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" value="" id="nominee_father_name" name="nominee_father_name" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label p-0">Relation With Client </label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" value="" id="nominee_relation" name="nominee_relation" />
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label">Contact No#</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="text-start form-control form-control-sm NumberValidate" value="" id="nominee_contact_no" name="nominee_contact_no" />
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3">
                                    <label class="col-form-label">CNIC No# </label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm cnic" value="" id="nominee_cnic_no" name="nominee_cnic_no" />
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</form>
@endpermission

@section('pageJsScript')
    <script src="{{ asset('/pages/sale/customer/create.js') }}"></script>
@endsection

@section('scriptCustom')
    <script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
    <script>
        $(".cnic").inputmask({
            'mask': '99999-9999999-9'
        });
    </script>
        <script>
            //Reset Image on Cross Click
            $(document).ready(function() {
                $('#om_resetInput').on('click', function() {
                    $('#om_image_url').val('');
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
