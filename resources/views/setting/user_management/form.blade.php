@extends('layouts.form')
@section('title', $data['title'])
@section('style')
    <style>
        .permission_table th, .permission_table td {
           /* padding: 4px 2px;*/
            text-align: center;
        }
        .permission_table th:first-child, .permission_table td:first-child {
            text-align: left;
        }

    </style>
@endsection

@section('content')

    @php

        $id = isset($data['id'])?$data['id']:"";
    @endphp

    <form id="user_management_form" class="user_management_form" action="{{route('setting.user-management.store',isset($id)?$id:"")}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            @if($id !== "")
                            <button type="submit" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                            @endif
                        </div>
                        <div class="card-link">
                            <a href="{{$data['create_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">User <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="user_id" name="user_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['users'] as $user)
                                                <option value="{{$user->id}}" {{($user->id == $id)?"selected":""}}> {{ $user->name }} - {{ $user->email }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Check All</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input class="form-check-input" type="checkbox" id="check_all">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="all_permissions">
                            @foreach($data['menus']['admin_menu'] as $name=>$admin_menus)
                                <div class="col-lg-12">
                                    @php
                                        $w = 80/count($data['menus']['module_act']);
                                    @endphp
                                    <table class="table permission_table table-bordered" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="20%">{{$admin_menus['name']}}</th>
                                            @foreach($data['menus']['module_act'] as $module_act)
                                                <th width="{{$w}}%">{{$module_act}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($admin_menus['child'] as $admin_menu)
                                            @if($admin_menu['dname'] != "")
                                                <tr>
                                                    <td>{{$admin_menu['dname']}}</td>
                                                    @foreach($data['menus']['module_act'] as $module_act)
                                                        <td>
                                                            @php $showCheckbox = false; @endphp
                                                            @php $per_id = ""; @endphp
                                                            @php $menu_name = $admin_menu['name'].'-'.strtolower(strtoupper(trim($module_act))); @endphp
                                                            @foreach($admin_menu['action'] as $action)
                                                                @php
                                                                    $per_id = isset($data['permission_list'][$menu_name])?$data['permission_list'][$menu_name]:"";
                                                                    if(strtolower(strtoupper(trim($action))) == strtolower(strtoupper(trim($module_act)))){
                                                                        $showCheckbox = true;
                                                                    }
                                                                @endphp
                                                            @endforeach
                                                            @if($showCheckbox && $per_id != "")
                                                                @if(isset($data['user_per_list']) && in_array($per_id,$data['user_per_list']))
                                                                    <input type="checkbox" value="{{$per_id}}" name="permissions[]" checked>
                                                                @else
                                                                    <input type="checkbox" value="{{$per_id}}" name="permissions[]">
                                                                @endif
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                        @foreach($admin_menus['child'] as $admin_menu)
                                            @if($admin_menu['dname'] == "")
                                                @foreach($admin_menu['sub_child'] as $sub_child)
                                                    <tr>
                                                        <td>{{$sub_child['dname']}}</td>
                                                        @foreach($data['menus']['module_act'] as $module_act)
                                                            <td>
                                                                @php $showCheckbox = false; @endphp
                                                                @php $per_id = ""; @endphp
                                                                @php $menu_name = $sub_child['name'].'-'.strtolower(strtoupper(trim($module_act))); @endphp
                                                                @foreach($sub_child['action'] as $action)
                                                                    @php
                                                                        $per_id = isset($data['permission_list'][$menu_name])?$data['permission_list'][$menu_name]:"";
                                                                        if(strtolower(strtoupper(trim($action))) == strtolower(strtoupper(trim($module_act)))){
                                                                            $showCheckbox = true;
                                                                        }
                                                                    @endphp
                                                                @endforeach
                                                                @if($showCheckbox && $per_id != "")
                                                                    @if(isset($data['user_per_list']) && in_array($per_id,$data['user_per_list']))
                                                                        <input type="checkbox" value="{{$per_id}}" name="permissions[]" checked>
                                                                    @else
                                                                        <input type="checkbox" value="{{$per_id}}" name="permissions[]">
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if(session()->has('status') && session('status') == 'success' && session()->has('message'))
        <div id="toast-container" class="toast-container toast-top-right">
            <div class="toast toast-success" aria-live="polite" style="display: block;">
                <button type="button" class="toast-close-button" role="button">×</button>
                <div class="toast-title">Success!</div>
                <div class="toast-message">{{ session('message') }}</div>
            </div>
        </div>
    @endif
    @if(session()->has('status') && session('status') == 'error' && session()->has('message'))
        <div id="toast-container" class="toast-container toast-top-right">
            <div class="toast toast-error" aria-live="polite" style="display: block;">
                <button type="button" class="toast-close-button" role="button">×</button>
                <div class="toast-title">Error!</div>
                <div class="toast-message">{{ session('message') }}</div>
            </div>
        </div>
    @endif

@endsection

@section('pageJs')
@endsection

@section('script')
    @if($id == "")
        <script>
            $('form').find('input[type="checkbox"]').attr('disabled',true)
        </script>
    @endif
    <script>
        $('#user_id').on('change', function() {
            var val = $(this).val();
            if(val == 0){
                window.location.href = '/setting/user-management/form';
            }else{
                var url = '/setting/user-management/form/'+val;
                window.location.href = url;
            }
        });
        $('#toast-container').delay(3000).fadeOut('slow');;
        $('#check_all').on('click', function() {
            if($(this).is(":checked") == true) {
                var checkAll = true
            }else{
                var checkAll = false
            }
            $('#all_permissions').find('input').each(function(){
                if(checkAll) {
                    $(this).prop('checked',true)
                }else{
                    $(this).prop('checked',false)
                }
            });
        });

        $('.permission_table input[type="checkbox"]').click(function(){
            $(".permission_table tr").each(function(){
                if(!$(this).find('input[type="checkbox"]').is('checked')){
                    $('#check_all').prop('checked', false);
                }
            })
        })

    </script>
@endsection
