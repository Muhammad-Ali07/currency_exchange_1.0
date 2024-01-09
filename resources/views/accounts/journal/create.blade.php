@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
    @permission($data['permission'])
    <form id="journal_create" class="journal_create" action="{{route('accounts.journal.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="card-left-side">
                            <h4 class="card-title">{{$data['title']}}</h4>
                            <button type="submit" name="current_action_id" value="store" class="btn btn-success btn-sm waves-effect waves-float waves-light">Save</button>
                            <button type="submit" name="current_action_id" value="post" class="btn btn-warning btn-sm waves-effect waves-float waves-light">Post</button>
                        </div>
                        <div class="card-link">
                            <a href="{{$data['list_url']}}" class="btn btn-secondary btn-sm waves-effect waves-float waves-light">Back</a>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="mb-1 row">
                            <div class="col-sm-12">
                                <h6>{{$data['voucher_no']}}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Date <span class="required">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="date" name="date" class="form-control form-control-sm flatpickr-basic flatpickr-input" placeholder="YYYY-MM-DD" value="{{date('Y-m-d')}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <div class="data_entry_header">
                                    <div class="hiddenFiledsCount" style="display: inline-block;"><span>0</span> fields hide</div>

                                    <div class="dropdown chart-dropdown" style="display: inline-block;">
                                        <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                        @php
                                            $headings = ['Sr','Account Code','Account Name','Description','Debit','Credit'];
                                        @endphp
                                        <ul class="listing_dropdown dropdown-menu dropdown-menu-end">
                                            @foreach($headings as $key=>$heading)
                                                <li class="dropdown-item">
                                                    <label>
                                                        <input value="{{$key}}" type="checkbox" checked> {{$heading}}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-lg-12">
                                <div id="erp_grid_table" class="egt">
                                    <div class="erp_form___block">
                                        <div class="table-scroll form_input__block">
                                            <table class="egt_form_table table table-bordered">
                                                <thead class="egt_form_header">
                                                <tr class="egt_form_header_title">
                                                    <th width="7%">Sr</th>
                                                    <th width="20%">Account Code</th>
                                                    <th width="22%">Account Name</th>
                                                    <th width="22%">Description</th>
                                                    <th width="16%">Debit</th>
                                                    <th width="16%">Credit</th>
                                                    <th width="13%" class="text-center">Action</th>
                                                </tr>
                                                <tr class="egt_form_header_input">
                                                    <td>
                                                        <input id="egt_sr_no" readonly type="text" class="form-control form-control-sm">
                                                        <input id="chart_id" type="hidden" class="chart_id form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="egt_chart_code" type="text" class="chart_code form-control form-control-sm text-left" placeholder="Press F2">
                                                    </td>
                                                    <td>
                                                        <input id="egt_chart_name" type="text" class="chart_name form-control form-control-sm" readonly>
                                                    </td>
                                                    <td>
                                                        <input id="egt_description" type="text" class="form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="egt_debit" type="text" class="FloatValidate debit form-control form-control-sm">
                                                    </td>
                                                    <td>
                                                        <input id="egt_credit" type="text" class="FloatValidate credit form-control form-control-sm">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" id="egt_add" class="egt_add btn btn-primary btn-sm">
                                                            <i data-feather='plus'></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </thead>
                                                <tbody class="egt_form_body">
                                                </tbody>
                                                <tfoot class="egt_form_footer">
                                                <tr class="egt_form_footer_total">
                                                    <td class="voucher-total-title">Total</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="voucher-total-debit text-end">
                                                        <span id="tot_debit"></span>
                                                        <input id="tot_voucher_debit" name="tot_voucher_debit" type="hidden" >
                                                    </td>
                                                    <td class="voucher-total-credit text-end">
                                                        <span id="tot_credit"></span>
                                                        <input id="tot_voucher_credit" name="tot_voucher_credit" type="hidden" >
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-form-label col-lg-2">Remarks:</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control form-control-sm" rows="3" name="remarks" id="remarks"></textarea>
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
    <script src="{{ asset('/pages/accounts/journal/create.js') }}"></script>
@endsection

@section('script')
    <script>
        var var_egt_fields = [

        ];
        var var_egt_required_fields = [
            {
                'id' : 'egt_chart_name',
                'message' : 'Account Name is required'
            },
            {
                'id' : 'egt_amount',
                'message' : 'Amount is required'
            }

        ];
        var var_egt_readonly_fields = ['egt_chart_code','egt_chart_name'];
    </script>
    <script src="{{asset('/js/jquery-12.js')}}"></script>
    <script src="{{asset('/pages/common/erp_grid.js')}}"></script>
    <script src="{{asset('/pages/help/chart_help.js')}}"></script>
    <script src="{{asset('/pages/common/account-calculations.js')}}"></script>
@endsection
