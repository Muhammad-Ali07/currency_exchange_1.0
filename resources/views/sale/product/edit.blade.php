@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('master.product.update',$data['id']);
        }
    @endphp
    @permission($data['permission'])
    <form id="product_edit" class="product_edit" action="{{route('master.product.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @if(!$data['view'])
            @csrf
            @method('patch')
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            @if($data['view'])
                                @permission($data['permission_edit'])
                                <a href="{{route('purchase.product-property.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
                                @endpermission
                            @else
                                <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Update</button>
                            @endif
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
                                        <h5>{{$current->code}}</h5>
                                    </div>
                                </div>
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
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12 mb-1">
                                    @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = $current->product_sign;@endphp
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

                                <div id="variations_list">

                                    @if(count($data['prod_var']) != 0)
                                        @php
                                            $prod_var = $data['prod_var'];
                                        @endphp
                                        @if(isset($prod_var['input']))
                                            @foreach($prod_var['input'] as $input_name=>$input_list)
                                                @php
                                                    $thix_list = $input_list[0];
                                                    $product_variation = $thix_list['product_variation'];
                                                @endphp
                                                <div class="mb-1 row">
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label">{{$product_variation['display_title']}}</label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm" value="{{isset($data['property_values'][$input_name])?current($data['property_values'][$input_name]):""}}" id="{{$product_variation['key_name']}}" name="pv[{{$input_name}}]">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if(isset($prod_var['yes_no']))
                                            @foreach($prod_var['yes_no'] as $yes_no_name=>$yes_no_list)
                                            @php
                                                $thix_list = $yes_no_list[0];
                                                $product_variation = $thix_list['product_variation'];
                                            @endphp
                                            <div class="mb-1 row">
                                                <div class="col-sm-4">
                                                    <label class="col-form-label">{{$product_variation['display_title']}}</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="form-check form-check-warning form-switch">
                                                        <input type="checkbox" class="form-check-input" id="{{$product_variation['key_name']}}" value="{{$thix_list['value']}}" name="pv[{{$yes_no_name}}]" {{isset($data['property_values'][$yes_no_name])?"checked":""}}>
                                                        <label class="form-check-label mb-50" for="corner_side">{{$thix_list['value']}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        @if(isset($prod_var['radio']))
                                            @foreach($prod_var['radio'] as $radio_name=>$radio_lists)
                                        @php
                                            $radio_list_html = "";
                                        @endphp
                                        @foreach($radio_lists as $k=>$radio_list)
                                            @php
                                                $product_variation = $radio_list['product_variation'];
                                                $title = $product_variation['display_title'];
                                                $key_name = $product_variation['key_name'].$k;
                                                $checked = (isset($data['property_values'][$radio_name]) && current($data['property_values'][$radio_name]) == $radio_list['value'])?"checked":"";
                                                $radio_list_html .= '<div class="form-check form-check-inline">';
                                                $radio_list_html .= '<input class="form-check-input" type="radio" name="pv['.$radio_name.']" id="'.$key_name.'" value="'.$radio_list['value'].'" '.$checked.'>';
                                                $radio_list_html .= '<label class="form-check-label" for="'.$key_name.'">'.$radio_list['value'].'</label>';
                                                $radio_list_html .= '</div>';
                                            @endphp
                                        @endforeach
                                        <div class="mb-1 row">
                                            <div class="col-sm-4">
                                                <label class="col-form-label">{{$title}}</label>
                                            </div>
                                            <div class="col-sm-8">
                                                {!! $radio_list_html !!}
                                            </div>
                                        </div>
                                    @endforeach
                                        @endif
                                        @if(isset($prod_var['select']))
                                            @foreach($prod_var['select'] as $select_name=>$select_lists)
                                                @php
                                                    $select_list_html = "";
                                                @endphp
                                                @foreach($select_lists as $k=>$select_list)
                                                    @php
                                                        $product_variation = $select_list['product_variation'];
                                                        $title = $product_variation['display_title'];
                                                        $key_name = $product_variation['key_name'];
                                                        $value = $select_list['value'];
                                                        $selected = (isset($data['property_values'][$select_name]) && current($data['property_values'][$select_name]) == $value)?"selected":"";
                                                        $select_list_html .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
                                                    @endphp
                                                @endforeach
                                                <div class="mb-1 row">
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label">{{$title}}</label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <select class="select2 form-select" id="{{$key_name}}" name="pv[{{$select_name}}]">
                                                            <option value="0" selected>Select</option>
                                                            {!! $select_list_html !!}
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if(isset($prod_var['checkbox']))
                                            @foreach($prod_var['checkbox'] as $checkbox_name=>$checkbox_lists)
                                            @php
                                                $checkbox_list_html = "";
                                            @endphp
                                            @foreach($checkbox_lists as $k=>$checkbox_list)
                                                @php
                                                    $product_variation = $checkbox_list['product_variation'];
                                                    $title = $product_variation['display_title'];
                                                    $key_name = $product_variation['key_name'].$k;
                                                    $value = $checkbox_list['value'];
                                                    $checked = (isset($data['property_values'][$checkbox_name]) && in_array($value,$data['property_values'][$checkbox_name]))?"checked":"";
                                                    $checkbox_list_html .= '<div class="form-check form-check-inline">';
                                                    $checkbox_list_html .= '<input class="form-check-input" type="checkbox" name="pv['.$checkbox_name.'][]" id="'.$key_name.'" value="'.$checkbox_list['value'].'" '.$checked.'>';
                                                    $checkbox_list_html .= '<label class="form-check-label" for="'.$key_name.'">'.$checkbox_list['value'].'</label>';
                                                    $checkbox_list_html .= '</div>';
                                                @endphp
                                            @endforeach
                                            <div class="mb-1 row">
                                                <div class="col-sm-4">
                                                    <label class="col-form-label">{{$title}}</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    {!! $checkbox_list_html !!}
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                    @endif
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
    <script>
        $(document).on('change','#buyable_type_id',function(){
            var validate = true;
            var thix = $(this);
            var val = thix.find('option:selected').val();
            if(valueEmpty(val)){
               // ntoastr.error("Select Buyable Type");
                validate = false;
               // return false;
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
                    url: '{{ route('purchase.product-variation.getProductVariations') }}',
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
@endsection

@section('script')

@endsection
