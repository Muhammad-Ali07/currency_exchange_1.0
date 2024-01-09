@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('setting.city.update',$data['id']);
        }
    @endphp
    <form id="city_edit" class="city_edit" action="{{isset($url)?$url:""}}"  method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('setting.city.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                                        <label class="col-form-label">Region <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="select2 form-select" id="region_id" name="region_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['countries'] as $country)
                                                <optgroup label="{{$country->name}}">
                                                    @foreach($country['regions'] as $region)
                                                        <option value="{{$region->id}}" {{$region->id == $current->region_id?"selected":""}}> {{$region->name}} </option>
                                                    @endforeach
                                                </optgroup>
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
                                        <label class="col-form-label">Name <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->name}}" id="name" name="name" />
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
    <script src="{{ asset('/pages/setting/city/edit.js') }}"></script>
@endsection

@section('script')

@endsection
