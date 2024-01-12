@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="product_create" class="product_create" action="{{route('master.product.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                    <div class="col-md-6">
                                        <h5>{{$data['code']}} </h5>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="" id="product_sign" name="product_name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Product Type</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="product_type" name="product_type">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['product_types'] as $product_types)
                                                <option value="{{$product_types}}"> {{$product_types}} </option>
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
                                        <input class="form-control form-control-sm" type="file" value="{{ $img }}" id="product_image_url" name="product_image"/>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
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
    <script src="{{ asset('/pages/purchase/product/create.js') }}"></script>
    <script>
        $(document).on('change','#buyable_type_id',function(){
            var validate = true;
            var thix = $(this);
            var val = thix.find('option:selected').val();
            if(valueEmpty(val)){
                ntoastr.error("Select Buyable Type");
                validate = false;
                return false;
            }
            if(validate){
                var formData = {
                    buyable_type_id : val
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '',
                    dataType	: 'json',
                    data        : formData,
                    success: function(response,data) {
                        if(response.status == 'success'){
                            var prod_var = response.data['prod_var'];
                            var variations_list = "";

                            var input_variations = prod_var['input'];
                            for (const input_item in input_variations) {
                                var thix_item = input_variations[input_item][0];
                                variations_list += '<div class="mb-1 row">\n' +
                                    '  <div class="col-sm-4">\n' +
                                    '  <label class="col-form-label">'+thix_item['product_variation']['display_title']+'</label>\n' +
                                    '  </div>\n' +
                                    '  <div class="col-sm-8">\n' +
                                    '  <input type="text" class="form-control form-control-sm" value="" id="'+thix_item['product_variation']['key_name']+'" name="pv['+input_item+']" />\n' +
                                    '  </div>\n' +
                                    '</div>';
                            }

                            var yes_no_variations = prod_var['yes_no'];
                            for (const yes_no_item in yes_no_variations) {
                                var thix_item = yes_no_variations[yes_no_item][0];
                                var key_name = thix_item['product_variation']['key_name'];
                                var value = thix_item['value'];
                                variations_list += '<div class="mb-1 row">\n' +
                                    '    <div class="col-sm-4">\n' +
                                    '    <label class="col-form-label">'+thix_item['product_variation']['display_title']+'</label>\n' +
                                    '   </div>\n' +
                                    '   <div class="col-sm-8">\n' +
                                    '     <div class="form-check form-check-warning form-switch">\n' +
                                    '        <input type="checkbox" class="form-check-input" id="'+key_name+'"  value="'+value+'" name="pv['+yes_no_item+']">\n' +
                                    '        <label class="form-check-label mb-50" for="'+key_name+'" >'+value+'</label>' +
                                    '     </div>'+
                                    '   </div>\n' +
                                    '</div>';
                            }

                            var radio_variations = prod_var['radio'];
                            for (const radio_item in radio_variations) {
                                var thix_item = radio_variations[radio_item];
                                var thix_length = thix_item.length;
                                console.log(thix_item.length);
                                var radio_opt = "";
                                for(var i=0;i<thix_length;i++){
                                    var title = thix_item[i]['product_variation']['display_title'];
                                    var key_name = thix_item[i]['product_variation']['key_name'];
                                    radio_opt += '<div class="form-check form-check-inline">\n' +
                                        ' <input class="form-check-input" type="radio" name="pv['+radio_item+']" id="'+key_name+(i+1)+'" value="'+thix_item[i]['value']+'">\n' +
                                        ' <label class="form-check-label" for="'+key_name+(i+1)+'">'+thix_item[i]['value']+'</label>\n' +
                                        '</div>';
                                }
                                variations_list += '<div class="mb-1 row">\n' +
                                    '   <div class="col-sm-4">\n' +
                                    '   <label class="col-form-label">'+title+'</label>\n' +
                                    '  </div>\n' +
                                    '  <div class="col-sm-8">\n' +radio_opt +
                                    ' </div>\n' +
                                    ' </div>';
                            }

                            var select_variations = prod_var['select'];
                            for (const select_item in select_variations) {
                                var thix_item = select_variations[select_item];
                                var thix_length = thix_item.length;
                                console.log(thix_item.length);
                                var select_opt = "";
                                for(var i=0;i<thix_length;i++){
                                    var title = thix_item[i]['product_variation']['display_title'];
                                    var key_name = thix_item[i]['product_variation']['key_name'];
                                    var value = thix_item[i]['value'];
                                    select_opt += '<option value="'+value+'">'+value+'</option>';
                                }
                                variations_list += '<div class="mb-1 row">\n' +
                                    '  <div class="col-sm-4">\n' +
                                    '  <label class="col-form-label">'+title+'</label>\n' +
                                    '  </div>\n' +
                                    '  <div class="col-sm-8">\n' +
                                    '  <select class="select2 form-select" id="'+key_name+'" name="pv['+select_item+']">\n' +
                                    '  <option value="0" selected>Select</option>\n' + select_opt +
                                    '  </select>\n' +
                                    '  </div>\n' +
                                    ' </div>';
                            }

                            var checkbox_variations = prod_var['checkbox'];
                            for (const checkbox_item in checkbox_variations) {
                                var thix_item = checkbox_variations[checkbox_item];
                                var thix_length = thix_item.length;
                                console.log(thix_item.length);
                                var checkbox_opt = "";
                                for(var i=0;i<thix_length;i++){
                                    var title = thix_item[i]['product_variation']['display_title'];
                                    var key_name = thix_item[i]['product_variation']['key_name'];
                                    var value = thix_item[i]['value'];
                                    checkbox_opt += '<div class="form-check form-check-inline">\n' +
                                        ' <input class="form-check-input" type="checkbox" name="pv['+checkbox_item+'][]" id="'+value+(i+1)+'" value="'+value+'">\n' +
                                        '   <label class="form-check-label" for="'+value+(i+1)+'">'+value+'</label>\n' +
                                        '  </div>';
                                }
                                variations_list += '<div class="mb-1 row">\n' +
                                    '   <div class="col-sm-4">\n' +
                                    '  <label class="col-form-label">'+title+'</label>\n' +
                                    '  </div>\n' +
                                    '  <div class="col-sm-8">\n' + checkbox_opt+
                                    '  </div>\n' +
                                    '</div>';
                            }

                            $('form').find('#variations_list').html(variations_list);
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

@section('script')

@endsection
