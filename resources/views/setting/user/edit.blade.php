@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('setting.user.update',$data['id']);
        }
    @endphp
    <form id="user_edit" class="user_edit" action="{{isset($url)?$url:""}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('setting.user.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label disabled class="col-form-label">Email <span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="{{$current->email}}" id="email" name="email" />
                                            </div>
                                        </div>
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Branch<span class="required">*</span></label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="select2 form-select" id="branch_id" name="branch_id">
                                                    <option value="0" selected>Select</option>
                                                    @foreach($data['branches'] as $branch)
                                                        <option value="{{$branch->id}}" {{$current->branch_id == $branch->id?"selected":""}}> {{$branch->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Optional Project</label>
                                            </div>
                                            <div class="col-sm-9">
                                                @php $projects = []; @endphp
                                                @if(count($current->projects) != 0)
                                                    @foreach($current->projects as $user_project)
                                                        @php
                                                            if($current->project_id != $user_project->id){
                                                                $projects[] = $user_project->id;
                                                            }
                                                        @endphp
                                                    @endforeach
                                                @endif
                                                <select class="select2 form-select" id="projects" name="projects[]" multiple>
                                                    @foreach($data['projects'] as $project_list)
                                                        <option value="{{$project_list->id}}" {{in_array($project_list->id,$projects)?"selected":""}}> {{$project_list->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="status" name="status"
                                                {{$current->user_status == 1?"checked":""}}>
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
    <script src="{{ asset('/pages/setting/user/edit.js') }}"></script>
@endsection

@section('script')

@endsection
