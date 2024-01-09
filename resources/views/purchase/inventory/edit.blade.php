@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    @php
        $current = $data['current'];
        if(!$data['view']){
            $url = route('purchase.inventory.update',$data['id']);
        }
    @endphp
    <form id="product_edit" class="product_edit" action="{{isset($url)?$url:""}}" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                <a href="{{route('purchase.inventory.edit',$data['id'])}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Edit</a>
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
                                        <label class="col-form-label">Supplier <span class="required">*</span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="supplier_id" name="supplier_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['suppliers'] as $supplier)
                                                <option value="{{$supplier->id}}" {{$supplier->id == $current->supplier_id ?"selected":""}}> {{$supplier->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Manufacturer <span class="required">*</span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="manufacturer_id" name="manufacturer_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['manufacturers'] as $manufacturer)
                                                <option value="{{$manufacturer->id}}"  {{$manufacturer->id == $current->manufacturer_id ?"selected":""}}> {{$manufacturer->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Brand <span class="required">*</span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" id="brand_id" name="brand_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['brands'] as $brand)
                                                <option value="{{$brand->id}}" {{$brand->id == $current->brand_id ?"selected":""}}> {{$brand->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Parent Category <span class="required">*</span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select parentCategoryList" id="parent_category" name="parent_category">
                                            <option value="0" selected>Select</option>
                                            @foreach($data['categories'] as $parent_category)
                                                <option value="{{$parent_category->id}}" {{$parent_category->id == $current->parent_category ?"selected":""}}> {{$parent_category->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Child Category <span class="required">*</span> </label>
                                    </div>
                                    <div class="col-sm-8">
                                        @php
                                            $childes = \App\Models\Category::where(['parent_id'=>$current->parent_category])->get()
                                        @endphp
                                        <select class="select2 form-select childCategoryList" id="category_id" name="category_id">
                                            <option value="0" selected>Select</option>
                                            @foreach($childes as $child)
                                                <option value="{{$child->id}}" {{$child->id == $current->category_id ?"selected":""}}> {{$child->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Registration No</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->external_item_id}}" id="external_item_id" name="external_item_id" />
                                    </div>
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
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Is Taxable</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-primary form-switch">
                                            <input type="checkbox" class="form-check-input" id="is_taxable" name="is_taxable" {{$current->is_taxable == 1?"checked":""}}>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Purchase Price </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->default_purchase_price}}" id="default_purchase_price" name="default_purchase_price" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Stock on Hand Units</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->stock_on_hand_units}}" id="stock_on_hand_units" name="stock_on_hand_units" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label p-0">Stock on Hand Packages</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{$current->stock_on_hand_packages}}" id="stock_on_hand_packages" name="stock_on_hand_packages" />
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
    <script src="{{ asset('/pages/purchase/product/edit.js') }}"></script>
@endsection

@section('script')

@endsection
