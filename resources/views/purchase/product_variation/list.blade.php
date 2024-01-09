@extends('layouts.datatable')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    <div class="datatable">
        <!-- Datatable -->
        <section id="ajax-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="card-left-side">
                                <h4 class="card-title">{{$data['title']}}</h4>
                            </div>
                            <div class="card-link">
                                @permission($data['permission_create'])
                                <a href="{{route('purchase.product-variation.create')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">Create</a>
                                @endpermission
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-datatable">
                                @permission($data['permission_list'])
                                <table class="datatables-ajax table table-responsive" data-url="{{route('purchase.product-variation.index')}}">
                                    <thead>
                                    <tr>
                                        <th class="cell-fit">Title</th>
                                        <th class="cell-fit">Property type</th>
                                        <th class="cell-fit">Value Type</th>
                                        <th class="cell-fit">Description</th>
                                        <th class="cell-fit"></th>
                                    </tr>
                                    </thead>
                                </table>
                                @endpermission
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Datatable -->
    </div>
@endsection

@section('pageJs')
@endsection

@section('script')

@endsection
