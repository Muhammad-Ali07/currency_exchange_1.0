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
                            <h4 class="card-title">Archive {{$data['title']}}</h4>
                        </div>
                        <div class="card-link">
                            <a href="{{route('accounts.bank-payment.index')}}" class="btn btn-primary btn-sm waves-effect waves-float waves-light">List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-datatable">
                            {{--@permission($data['permission_list'])--}}
                            <table class="datatables-ajax table table-responsive" data-url="{{route('accounts.bank-payment.revertList')}}">
                                <thead>
                                <tr>
                                    <th class="cell-fit">Date</th>
                                    <th class="cell-fit">Voucher No</th>
                                    <th class="cell-fit text-center">{{trans('label.draft_posted')}}</th>
                                    <th class="cell-fit">Remarks</th>
                                    <th class="cell-fit"></th>
                                </tr>
                                </thead>
                            </table>
                            {{--@endpermission--}}
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
