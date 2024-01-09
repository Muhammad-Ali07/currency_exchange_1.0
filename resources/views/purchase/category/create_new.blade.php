@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    <form id="category_create" class="category_create" action="{{route('purchase.category.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">Product Variations</h4>
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
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Buyable Type <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select" multiple id="category_type_id" name="category_type_id">
                                            <option value="1" selected>Villas</option>
                                            <option value="2" selected>Plot</option>
                                            <option value="3" selected>Apartment</option>
                                            <option value="4" selected>Elite Unit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Display Title<span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="Area" id="name4" name="name4" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Key Name<span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="area" id="name3" name="name3" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Description</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="Square Fit" id="name2" name="name2" />
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Value Type</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select class="select2 form-select"  id="bcategory_type_id" name="bcategory_type_id">
                                            <option value="0" selected>Select</option>
                                            <option value="1" >Input</option>
                                            <option value="2" >Select</option>
                                            <option value="3" >Checkbox</option>
                                            <option value="4" >Radio</option>
                                            <option value="5" >Yes / No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-1 row">
                                    <div class="col-sm-4">
                                        <label class="col-form-label">Options</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="row mb-1">
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="" id="name2" name="name2" />
                                            </div>
                                            <div class="col-sm-3">
                                                <button class="btn btn-sm btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-25"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="" id="name2" name="name2" />
                                            </div>
                                            <div class="col-sm-3">
                                                <button class="btn btn-sm btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-25"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="" id="name2" name="name2" />
                                            </div>
                                            <div class="col-sm-3">
                                                <button class="btn btn-sm btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-25"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" value="" id="name2" name="name2" />
                                            </div>
                                            <div class="col-sm-3">
                                                <button class="btn btn-sm btn-outline-danger text-nowrap px-1 waves-effect" data-repeater-delete="" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x me-25"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <button class="btn btn-icon btn-primary waves-effect waves-float waves-light" type="button" data-repeater-create="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            <span>Add New</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('pageJs')
    <script src="{{ asset('/pages/purchase/category/create.js') }}"></script>
@endsection

@section('script')
    <script>
        var select2Tag = $('.select2Tag');
      /*  $('#bcagory_type_id').select2({
            tags: true,
        });*/

        select2Tag.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                tags: true,
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
    </script>
@endsection
