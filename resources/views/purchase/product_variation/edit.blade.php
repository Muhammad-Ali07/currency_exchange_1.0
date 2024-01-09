@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('purchase.product-variation.update',$data['id']);
        }
    @endphp
    <form id="product_variation_edit" class="product_variation_edit" action="{{route('purchase.product-variation.update',$data['id'])}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('purchase.product-variation.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Property type <span class="required">*</span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" multiple id="buyable_type_id" name="buyable_type_id[]">
                                            @foreach($data['buyable_type'] as $buyable_type)
                                                <option value="{{$buyable_type->id}}" {{in_array($buyable_type->id,$data['buyable_types'])?"selected":""}}> {{$buyable_type->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Display Title <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->display_title}}" id="display_title" name="display_title" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Description</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->description}}" id="description" name="description" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Value Type</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="value_type" name="value_type">
                                            <option value="input" {{$current->value_type == 'input' ?"selected":""}}>Input</option>
                                            <option value="select" {{$current->value_type == 'select' ?"selected":""}} >Select List</option>
                                            <option value="checkbox" {{$current->value_type == 'checkbox' ?"selected":""}} >Checkbox</option>
                                            <option value="radio" {{$current->value_type == 'radio' ?"selected":""}} >Radio</option>
                                            <option value="yes_no"  {{$current->value_type == 'yes_no' ?"selected":""}}>Yes / No</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="value_type_block" style="display: {{in_array($current->value_type,['select','checkbox','radio','yes_no'])?"block":"none"}}">
                                    <div class="row" id="select_options" style="display:  {{in_array($current->value_type,['select','checkbox'])?"block":"none"}}" >
                                        <div class="col-sm-4">
                                            <label class="col-form-label">Options</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="select_options_block">
                                                <div data-repeater-list="options_list">
                                                    @if(in_array($current->value_type,['select','checkbox']))
                                                    @foreach($data['options_data'] as $options_data_list)
                                                        @foreach($options_data_list as $options_data)
                                                            <div data-repeater-item>
                                                                <div class="row">
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control form-control-sm" value="{{$options_data['value']}}" name="option" />
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="mb-1">
                                                                            <button class="btn btn-sm btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                                <i data-feather="x" class="me-25"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        @break
                                                    @endforeach
                                                    @else
                                                        <div data-repeater-item>
                                                            <div class="row">
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control form-control-sm" value="" name="option" disabled/>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-1">
                                                                        <button class="btn btn-sm btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                                            <i data-feather="x" class="me-25"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                                            <i data-feather="plus" class="me-25"></i>
                                                            <span>Add New</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="radio_options"  style="display: {{$current->value_type == 'radio'?"block":"none"}}">
                                        @if($current->value_type == 'radio')
                                            @foreach($data['options_data'] as $options_data_list)
                                                @foreach($options_data_list as $options_data)
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="col-form-label">Options</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" value="{{$options_data['value']}}" name="options_list[][option]" />
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @break
                                            @endforeach
                                        @else
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="col-form-label">Options</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" value="" name="options_list[][option]" disabled/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="col-form-label">Options</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" value="" name="options_list[][option]" disabled/>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div id="yes_no_options"  style="display: {{$current->value_type == 'yes_no'?"block":"none"}}">
                                        @if($current->value_type == 'yes_no')
                                            @foreach($data['options_data'] as $options_data_list)
                                                @foreach($options_data_list as $options_data)
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="col-form-label">Options</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" value="{{$options_data['value']}}" name="options_list[][option]" />
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @break
                                            @endforeach
                                        @else
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="col-form-label">Options</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" value="" name="options_list[][option]" disabled/>
                                                </div>
                                            </div>
                                        @endif
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
    <script src="{{ asset('/pages/purchase/product_variation/edit.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).on('change','#value_type',function(){
            var thix = $(this);
            var val = thix.find('option:selected').val();
            var value_type_block = $('#value_type_block');
            var vt = ['select','checkbox','radio','yes_no'];
            if(vt.includes(val)){
                value_type_block.show();
                value_type_block.find('input').attr('disabled',false);
            }
            if(val == 'select' || val == 'checkbox'){
                value_type_block.find('#select_options').show();
                value_type_block.find('#radio_options').hide();
                value_type_block.find('#yes_no_options').hide();
                value_type_block.find('#radio_options').find('input').attr('disabled',true);
                value_type_block.find('#yes_no_options').find('input').attr('disabled',true);
            }
            if(val == 'radio'){
                value_type_block.find('#radio_options').show();
                value_type_block.find('#select_options').hide();
                value_type_block.find('#yes_no_options').hide();
                value_type_block.find('#select_options').find('input').attr('disabled',true);
                value_type_block.find('#yes_no_options').find('input').attr('disabled',true);
            }
            if(val == 'yes_no'){
                value_type_block.find('#yes_no_options').show();
                value_type_block.find('#select_options').hide();
                value_type_block.find('#radio_options').hide();
                value_type_block.find('#select_options').find('input').attr('disabled',true);
                value_type_block.find('#radio_options').find('input').attr('disabled',true);
            }
            if(val == 'input'){
                value_type_block.hide();
                value_type_block.find('input').attr('disabled',true);
            }
        });

        $(function () {
            'use strict';
            // form repeater jquery
            $('.select_options_block').repeater({
                show: function () {
                    $(this).slideDown();
                    // Feather Icons
                    if (feather) {
                        feather.replace({ width: 14, height: 14 });
                    }
                },
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                }
            });
        });
    </script>
@endsection
