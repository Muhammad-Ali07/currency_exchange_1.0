@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('purchase.category.update',$data['id']);
        }
    @endphp
    <form id="category_edit" class="category_edit" action="{{isset($url)?$url:""}}"  method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('purchase.category.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                                        <label class="col-form-label">Category Type <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="category_type_id" name="category_type_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['category_types'] as $category_types)
                                                <option value="{{$category_types->id}}" {{$category_types->id == $current->category_type_id?"selected":""}}> {{$category_types->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Parent Category </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="parent_id" name="parent_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['parent_category'] as $parent_category)
                                                <option value="{{$parent_category->id}}" {{$parent_category->id == $current->parent_id?"selected":""}}> {{$parent_category->name}} </option>
                                            @endforeach
                                        </select>
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
    <script src="{{ asset('/pages/purchase/category/edit.js') }}"></script>
@endsection

@section('script')

@endsection
