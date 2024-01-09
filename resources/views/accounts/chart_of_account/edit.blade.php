@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('accounts.chart-of-account.update',$data['id']);
        }
    @endphp
    <form id="chart_of_account_edit" class="chart_of_account_edit" action="{{isset($url)?$url:""}}"  method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('accounts.chart-of-account.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Level </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="radio-inline">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio1" value="1" {{$current->level == 1?"checked":""}} disabled>
                                                <label class="form-check-label" for="inlineRadio1">Level 1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio2" value="2" {{$current->level == 2?"checked":""}} disabled>
                                                <label class="form-check-label" for="inlineRadio2">Level 2</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio3" value="3" {{$current->level == 3?"checked":""}} disabled>
                                                <label class="form-check-label" for="inlineRadio3">Level 3</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="level" id="inlineRadio4" value="4" {{$current->level == 4?"checked":""}} disabled>
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
                                        <select class="select2 form-select parentAccountList" id="parent_account" name="parent_account" disabled>
                                            @if($current->level == 1)
                                                <option value="0" selected>Select</option>
                                            @else
                                                <option value="{{$current->parent_account_id}}" selected>{{$current->parent_account_code}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Code <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->code}}" id="code" name="code" readonly/>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->name}}" id="name" name="name" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="status" name="status" {{$current->status==1?"checked":""}}>
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
    <script src="{{ asset('/pages/accounts/chart_of_account/edit.js') }}"></script>
@endsection

@section('script')

@endsection
