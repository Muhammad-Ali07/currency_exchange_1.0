@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('setting.staff.update',$data['id']);
        }
    @endphp
    <form id="staff_edit" class="staff_edit" action="{{isset($url)?$url:""}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('setting.staff.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-sm-12">
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
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Contact No# </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm validate_number" value="{{$current->contact_no}}" id="contact_no" name="contact_no" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">CNIC No# <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm cnic" value="{{$current->cnic_no}}" id="cnic_no" name="cnic_no" />
                                    </div>
                                </div>
                                {{--<div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Project <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select" id="project_id" name="project_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($data['projects'] as $project)
                                                        <option value="{{$project->id}}" {{$project->id == $current->project_id?"selected":""}}> {{$project->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Department <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select" id="department_id" name="department_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($data['departments'] as $department)
                                                        <option value="{{$department->id}}" {{$department->id == $current->department_id?"selected":""}}> {{$department->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @include('partials.address')
                            </div>
                        </div>
                        <div class="row">
                            <h3>Staff History </h3>
                        @include('setting.staff.staff_history')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    @endpermission
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/setting/staff/edit.js') }}"></script>
@endsection

@section('script')
    <script src="{{ asset('/js/jquery-inputmask.js') }}"></script>
    <script>
        $(".cnic").inputmask({
            'mask': '99999-9999999-9'
        });
    </script>

@endsection
