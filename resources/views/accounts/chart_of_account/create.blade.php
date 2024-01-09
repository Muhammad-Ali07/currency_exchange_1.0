@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="chart_of_account_create" class="chart_of_account_create" action="{{route('accounts.chart-of-account.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                        <label class="col-form-label">Level </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="radio-inline">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio1" value="1" checked>
                                                <label class="form-check-label" for="inlineRadio1">Level 1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio2" value="2">
                                                <label class="form-check-label" for="inlineRadio2">Level 2</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio3" value="3">
                                                <label class="form-check-label" for="inlineRadio3">Level 3</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio4" value="4">
                                                <label class="form-check-label" for="inlineRadio4">Level 4</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Parent Account </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select parentAccountList" id="parent_account" name="parent_account">
                                            <option value="0" selected>Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Code <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$data['code']}}" id="code" name="code" readonly/>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="" id="name" name="name" />
                                    </div>
                                </div>
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
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/accounts/chart_of_account/create.js') }}"></script>
@endsection

@section('script')
    <script>
        var levelOneCodeOnPageLoad = $('#code').val();
        $(document).on('click',"input[name='level']",function(){
            var validate = true;
            var thix = $(this);
            var val = thix.val();
            if(valueEmpty(val) && !val.includes([1,2,3,4])){
                ntoastr.error("Select Level");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    level : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('accounts.chart-of-account.getParentCoaList') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            $('#code').val('');
                            var charts = response.data['charts'];
                            var length = charts.length;
                            var options = "<option value='0' selected>Select</option>";
                            for(var i=0;i<length;i++){
                                if(charts[i]['name']){
                                    options += '<option value="'+charts[i]['code']+'">'+charts[i]['code']+" - "+charts[i]['name']+'</option>';
                                }
                            }
                            $('form').find('.parentAccountList').html(options);
                            if(val == 1){
                                $('#code').val(levelOneCodeOnPageLoad);
                            }
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
        $(document).on('change',"#parent_account",function(){
            var validate = true;
            var thix = $(this);
            var val = thix.find('option:selected').val();
            var level = $("input[name='level']:checked").val();
            if(valueEmpty(val)){
                ntoastr.error("Select Parent Account");
                validate = false;
                return false;
            }
            if(valueEmpty(level) && !level.includes([1,2,3,4])){
                ntoastr.error("Select Level");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    level : level,
                    parent_account : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('accounts.chart-of-account.getChildCodeByParentAccount') }}',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var code = response.data['code'];
                            $('#code').val(code);
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
@endsection
