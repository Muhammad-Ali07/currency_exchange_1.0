@extends('layouts.form')
@section('title', $data['title'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/page-faq.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/menu/menu-types/vertical-menu.css') }}">
<style>
    .bg-style{
        background-color: #fff !important;
        border: 1px solid #d8d6de !important;
    }
</style>
@endsection

@section('content')

    <!-- search header -->
    <section id="faq-search-filter">
        <form id="customer_ledger_report" class="customer_ledger_report faq-search-input" action="{{route('reports.customer.store')}}" method="post" autocomplete="off">
            @method('post')
            @csrf
            <div class="card faq-search" style="background-image: url('{{ asset('assets/images/banner/banner.png') }}')">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="text-danger">Customer Ledger Report</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <span class="text-danger" style="font-size: 18px;font-weight: 900;">Filters</span>
                            <button class="btn btn-danger btn-sm" type="submit">Generate</button>
                        </div>
                    </div>
                    <!-- main title -->

                    <!-- subtitle -->
                    <!-- search input -->
                    <div class="row">
                        <div class="col-lg-12">
                            {{-- <form id="customer_ledger_report" class="customer_ledger_report faq-search-input" action="{{route('reports.customer.customerLedgerReport')}}" method="post" enctype="multipart/form-data" autocomplete="off"> --}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <label class="form-label mt-1" for="basic-default-password1"><b>Date</b></label>
                                            <div class="col-lg-12">
                                                <div class="w-100 input-group mb-2">
                                                    <span class="input-group-text" id="basic-addon7">From</span>
                                                    <input type="text" id="from_date" name="from_date" class="form-control bg-style flatpickr-basic" placeholder="YYYY-MM-DD" />
                                                    <span class="input-group-text" id="basic-addon7">To</span>
                                                    <input type="text" id="to_date" name="to_date" class="form-control bg-style flatpickr-basic" placeholder="YYYY-MM-DD" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <label class="form-label" for="basic-default-password1"><b>Customer</b></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group eg_help_block w-100">
                                                        <span class="input-group-text" id="addon_remove"><i data-feather='minus-circle'></i></span>
                                                        <input id="customer_name" type="text" placeholder="Click here..." class="customer_name form-control form-control-sm text-left">
                                                        <input id="customer_id" type="hidden" name="customer_id">
                                                    </div>
                                                </div>
                                                {{-- <div class="w-100 input-group mb-2">

                                                </div> --}}
                                        </div>
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection

@section('pageJs')
@endsection

@section('script')
<script>
        var from_date = $('#from_date');
          if (from_date.length) {
            from_date.flatpickr({
                  dateFormat: 'd-m-Y',
              });
          }

          var to_date = $('#to_date');
          if (to_date.length) {
            to_date.flatpickr({
                  dateFormat: 'd-m-Y',
              });
          }

</script>
<script src="{{asset('/pages/help/customer_help.js')}}"></script>

@endsection
