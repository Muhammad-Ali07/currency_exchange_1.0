@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="product_create" class="product_create" action="{{route('purchase.product-property.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                        <h5>{{$data['code']}}</h5>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Plot No <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="" id="name" name="name" />
                                    </div>
                                </div>
                                {{--<div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Project <span class="required">*</span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="project_id" name="project_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['project'] as $project)
                                                <option value="{{$project->id}}"> {{$project->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>--}}
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Sale Price </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="" id="default_sale_price" name="default_sale_price" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Registration No</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="" id="external_item_id" name="external_item_id" />
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
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Property Type </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="buyable_type_id" name="buyable_type_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['buyable'] as $buyable)
                                                <option value="{{$buyable->id}}"> {{$buyable->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="variations_list">

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
