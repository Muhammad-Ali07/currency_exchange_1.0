@extends('layouts.print_layout')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')
@permission($data['permission'])
@section('page_title', $data['title'])
@php
    $current = $data['current'];
@endphp
<table class="info-table" width="100%">
    <tbody>
        <tr>
            <td width="33.33%">
                <div class="info-block">
                    <span class="heading heading-block">Code :</span>
                    <span class="normal normal-block">{{$current->voucher_no}}</span>
                </div>
                <div class="info-block">
                    <span class="heading heading-block">Date :</span>
                    <span class="normal-block">{{date('Y-m-d',strtotime($current->date))}}</span>
                </div>
            </td>
            <td width="33.33%">
            </td>
            <td width="33.33%">
                <div class="info-block">
                    <span class="heading heading-block">Remarks :</span>
                    <span class="normal-block">{{$current->remarks}}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<table class="data-table" width="100%">
    <thead>
        <tr>
            <th>Sr No#</th>
            <th>Account Code</th>
            <th>Account Name</th>
            <th>Cheque No#</th>
            <th>Cheque Date</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>
    <tbody>
        @if(isset( $data['dtl']) && count( $data['dtl']) > 0)
            @foreach($data['dtl'] as $dtl)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$dtl->chart_account_code}}</td>
                    <td>{{$dtl->chart_account_name}}</td>
                    <td>{{$dtl->cheque_no}}</td>
                    @php
                        $cheque_date = date('d-m-Y',strtotime($dtl->cheque_date));
                        $cheque_date = ($cheque_date == '01-01-1970')?"":$cheque_date;
                    @endphp
                    <td>{{$cheque_date}}</td>
                    <td>{{$dtl->description}}</td>
                    <td class="text-right">{{number_format($dtl->debit,3)}}</td>
                    <td class="text-right">{{number_format($dtl->credit,3)}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<table class="mt-150" width="100%" valign="bottom">
    <tr>
        <th width="25%"><hr class="sign-line">{{trans('label.prepared_by')}}</th>
        <th width="25%"><hr class="sign-line">{{trans('label.authorized_by')}}</th>
        <th width="25%"></th>
        <th width="25%"></th>
    </tr>
</table>
@endpermission
@endsection
@section('script')
@endsection
