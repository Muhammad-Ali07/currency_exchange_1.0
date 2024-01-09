@extends('layouts.print_layout')
@section('title', $data['title'])
@section('style')
    <style>
        table.tbl-booking>thead>tr>th{
            height: 30px;
            vertical-align: middle;
        }
        table.tbl-booking>tbody>tr>td{
            height: 50px;
            vertical-align: top;
            padding-top: 5px;
        }
        .notes {
            margin: 35px 0px;
        }
    </style>
@endsection

@section('content')
@permission($data['permission'])
@section('page_title', $data['title'])
@php
    $current = $data['current'];
@endphp
<div><b>Booking Code:</b> {{$current->code}}</div>
<table class="data-table tbl-booking" width="100%">
    <thead>
        <tr>
            <th width="16.66%" class="text-left">Membership No.</th>
            <th width="16.66%" class="text-left">Member Name</th>
            <th width="16.66%" class="text-left">S/O,D/O,W/O</th>
            <th width="16.66%" class="text-left">Reg. No.</th>
            <th width="16.66%" class="text-left">Category</th>
            <th width="16.66%" class="text-left">Currency Note No.</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td>{{isset($current->customer->name)?$current->customer->name:""}}</td>
            <td>{{isset($current->customer->father_name)?$current->customer->father_name:""}}</td>
            <td></td>
            <td>{{isset($current->product->buyable_type->name)?$current->product->buyable_type->name:""}}</td>
            <td>{{$current->currency_note_no}}</td>
        </tr>
    </tbody>
</table>
<table class="data-table tbl-booking" width="100%">
    <thead>
    <tr>
        <th width="16.66%" class="text-left">Mailing Address</th>
        <th width="16.66%" class="text-left">Permanent Address</th>
        <th width="16.66%" class="text-left">CNIC Number</th>
        <th width="16.66%" class="text-left">Mobile No.</th>
        <th width="16.66%" class="text-left">Residence Number</th>
        <th width="16.66%" class="text-left">Email ID</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <div>
                {{isset($current->customer->addresses->address)?$current->customer->addresses->address:""}},
            </div>
            <div>
                {{isset($current->customer->addresses->city->name)?$current->customer->addresses->city->name:""}},
                {{isset($current->customer->addresses->region->name)?$current->customer->addresses->region->name:""}},
                {{isset($current->customer->addresses->country->name)?$current->customer->addresses->country->name:""}}
            </div>
        </td>
        <td>
            <div>
                {{isset($current->customer->addresses->address)?$current->customer->addresses->address:""}},
            </div>
            <div>
                {{isset($current->customer->addresses->city->name)?$current->customer->addresses->city->name:""}},
                {{isset($current->customer->addresses->region->name)?$current->customer->addresses->region->name:""}},
                {{isset($current->customer->addresses->country->name)?$current->customer->addresses->country->name:""}}
            </div>
        </td>
        <td>{{isset($current->customer->cnic_no)?$current->customer->cnic_no:""}}</td>
        <td>{{isset($current->customer->mobile_no)?$current->customer->mobile_no:""}}</td>
        <td>{{isset($current->customer->contact_no)?$current->customer->contact_no:""}}</td>
        <td>{{isset($current->customer->email)?$current->customer->email:""}}</td>
    </tr>
    </tbody>
</table>
<table class="data-table tbl-booking" width="100%">
    <thead>
    <tr>
        <th width="16.66%" class="text-left">File Status</th>
        <th width="16.66%" class="text-left">Payment</th>
        <th width="16.66%" class="text-left">Booking Person</th>
        <th width="51%" class="text-left">Property Detail</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{isset($current->file_status->name)?$current->file_status->name:""}}</td>
        <td>{{isset($current->property_payment_mode->name)?$current->property_payment_mode->name:""}}</td>
        <td>
            @if(isset($current->dealer->dealer->name))
                <b>Dealer:</b> {{$current->dealer->dealer->name}}
            @endif
            @if(isset($current->staff->staff->name))
                <b>Staff:</b> {{$current->staff->staff->name}}
            @endif
        </td>
        <td>
            @if(isset($current->product) && $current->product != null)
                @php
                  $prod = $current->product;
                  $sql = "SELECT p.id p_id,p.name p_name,p.buyable_type_id,pvs.value,pvs.product_variation_id,pv.display_title,pvs.sr_no FROM products p
                            left join property_variations pvs on pvs.product_id = p.id
                            left join product_variations pv on pv.id = pvs.product_variation_id
                            where p.id = $prod->id order by pv.display_title;";
                  $variations = \Illuminate\Support\Facades\DB::select($sql);
                  $lists = [];
                  foreach ($variations as $variation){
                      $lists[$variation->display_title][] = $variation->value;
                  }
                  //dd($lists);
                @endphp
                <div style="padding-bottom: 5px;">
                    <b>Product Name: </b>
                    <span>{{$prod->name}}</span>
                </div>
                @foreach($lists as $title=>$rows)
                    <div style="padding-bottom: 5px;width: 33%; float: left">
                        <b>{{$title}}:</b>
                        @if(count($rows) == 1)
                        @foreach($rows as $k=>$value)
                                <span>{{$value}}</span>
                        @endforeach
                        @else
                            @foreach($rows as $ki=>$val)
                                <span>{{$value}}, </span>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @endif
        </td>

    </tr>
    </tbody>
</table>
<h1>Nominee Information</h1>
<table class="data-table tbl-booking" width="100%">
    <thead>
    <tr>
        <th width="20%" class="text-left">Name</th>
        <th width="20%" class="text-left">S/O,D/O,W/O</th>
        <th width="20%" class="text-left">CNIC No.</th>
        <th width="20%" class="text-left">Cntact No.</th>
        <th width="20%" class="text-left">Relation with Client</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{isset($current->customer->nominee_name)?$current->customer->nominee_name:""}}</td>
        <td>{{isset($current->customer->nominee_father_name)?$current->customer->nominee_father_name:""}}</td>
        <td>{{isset($current->customer->nominee_cnic_no)?$current->customer->nominee_cnic_no:""}}</td>
        <td>{{isset($current->customer->nominee_contact_no)?$current->customer->nominee_contact_no:""}}</td>
        <td>{{isset($current->customer->nominee_relation)?$current->customer->nominee_relation:""}}</td>
    </tr>
    </tbody>
</table>

<div class="notes">
    **Membership no. will be generated once for one client, if a client has more than 1 plot or villa at the same time then one membership number will beapplied on all files.
    When we put CNIC the membership no will be shown and there would be an option for another entry for client property.
</div>

@endpermission
@endsection
@section('script')
@endsection
