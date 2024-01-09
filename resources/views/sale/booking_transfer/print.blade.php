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
        .mb-0{
            margin-bottom: 0px;
        }
        .center{
            width: 100px;
            height: 90px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection

@section('content')
@permission($data['permission'])
@section('page_title', $data['title'])
@php
    $current = $data['current'];
@endphp
<table class="data-table tbl-booking" width="100%">

    <thead>
        <tr><th colspan="5" style="background-color: #e9e9e9 !important;"><div class="" style="float:left;"><h2 class="mb-0">New Member Information:</b></div></th></tr>
        <tr>
            <th width="16.66%" class="text-left">Membership No.</th>
            <th width="16.66%" class="text-left">Member Name</th>
            <th width="16.66%" class="text-left">S/O,D/O,W/O</th>
            <th width="16.66%" class="text-left">Registration No.</th>
            {{-- <th width="16.66%" class="text-left">Category</th> --}}
            <th width="16.66%" class="text-left">Permanent Address</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $current->nm_membership_no }}</td>
            <td>{{isset($current->nm_customer->name)?$current->nm_customer->name:""}}</td>
            <td>{{isset($current->nm_customer->father_name)?$current->nm_customer->father_name:""}}</td>
            {{-- @dd($current->product->name); --}}
            <td>{{isset($current->nm_registration_no)?$current->nm_registration_no:""}}</td>
            <td>
                <div>
                    {{isset($current->nm_customer->addresses->address)?$current->nm_customer->addresses->address:""}},
                </div>
                <div>
                    {{isset($current->nm_customer->addresses->city->name)?$current->nm_customer->addresses->city->name:""}},
                    {{isset($current->nm_customer->addresses->region->name)?$current->nm_customer->addresses->region->name:""}},
                    {{isset($current->nm_customer->addresses->country->name)?$current->nm_customer->addresses->country->name:""}}
                </div>
            </td>
        </tr>
    </tbody>

    <thead>
    <tr>
        <th width="16.66%" class="text-left">Mailing Address</th>
        <th width="16.66%" class="text-left">CNIC Number</th>
        <th width="16.66%" class="text-left">Email ID</th>
        <th width="16.66%" class="text-left"></th>
        <th width="16.66%" class="text-left"></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <div>
                {{isset($current->nm_customer->addresses->address)?$current->nm_customer->addresses->address:""}},
            </div>
            <div>
                {{isset($current->nm_customer->addresses->city->name)?$current->nm_customer->addresses->city->name:""}},
                {{isset($current->nm_customer->addresses->region->name)?$current->nm_customer->addresses->region->name:""}},
                {{isset($current->nm_customer->addresses->country->name)?$current->nm_customer->addresses->country->name:""}}
            </div>
        </td>
        <td>{{isset($current->nm_customer->cnic_no)?$current->nm_customer->cnic_no:""}}</td>
        <td>{{isset($current->nm_customer->email)?$current->nm_customer->email:""}}</td>
        <td></td>
        <td></td>
    </tr>
    </tbody>

    <thead>
        <tr><th colspan="5"><div class="" style="float:left"><h2 class="mb-0">Nominee Information:</b></div></th></tr>
        <tr>
            <th width="16.66%" class="text-left">Nominee Name</th>
            <th width="16.66%" class="text-left">S/O,D/O,W/O</th>
            <th width="16.66%" class="text-left">CNIC</th>
            <th width="16.66%" class="text-left">Contact Number</th>
            <th width="16.66%" class="text-left">Relation with Client</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{isset($current->nm_customer->nominee_name)?$current->nm_customer->nominee_name:""}}</td>
            <td>{{isset($current->nm_customer->nominee_father_name)?$current->nm_customer->nominee_father_name:""}}</td>
            <td>{{isset($current->nm_customer->nominee_cnic_no)?$current->nm_customer->nominee_cnic_no:""}}</td>
            <td>{{isset($current->nm_customer->nominee_contact_no)?$current->nm_customer->nominee_contact_no:""}}</td>
            <td>{{isset($current->nm_customer->nominee_relation)?$current->nm_customer->nominee_relation:""}}</td>
        </tr>
    </tbody>
</table>

<table class="data-table tbl-booking" width="100%" style="margin-top:1%">
    <thead>
        <tr>
            <th colspan="5" style="background-color: #e9e9e9 !important;"><div class="" style="float:left"><h2 class="mb-0">Transfer Process:</b></div></th>
            <th class="text-left" style="background-color: #e9e9e9 !important;">Date: {{ date('d-m-Y', strtotime($current->date))}}</th>
        </tr>
        <tr>
            <th colspan="6" class="text-left"><h3>Seller Detail</h3></th>
        </tr>
        <tr>
            <th width="16.66%" class="text-left">Membership No.</th>
            <th width="16.66%" class="text-left">Member Name</th>
            <th width="16.66%" class="text-left">S/O,D/O,W/O</th>
            <th width="16.66%" class="text-left">Registration No.</th>
            <th width="16.66%" class="text-left">CNIC</th>
            <th width="16.66%" class="text-left">Plot/Elite/Villa #.</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{isset($current->om_membership_no)?$current->om_membership_no:""}}</td>
            <td>{{isset($current->om_customer_name)?$current->om_customer_name:""}}</td>
            <td>{{isset($current->om_customer->father_name)?$current->om_customer->father_name:""}}</td>
            <td>{{isset($current->om_registration_no)?$current->om_registration_no:""}}</td>
            <td>{{isset($current->om_cnic_no)?$current->om_cnic_no:""}}</td>
            <td>{{isset($current->product->name)?$current->product->name:""}}</td>
        </tr>
    </tbody>

    <thead>
        <tr>
            <th width="16.66%" class="text-left">Contact No.</th>
            <th width="16.66%" colspan="5" class="text-left">Address</th>
            {{-- <th width="16.66%" class="text-left">Category</th> --}}
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{isset($current->om_mobile_no)?$current->om_mobile_no:""}}</td>
            <td colspan="5">
                <div>
                    {{isset($current->om_customer->addresses->address)?$current->om_customer->addresses->address:""}},
                </div>
                <div>
                    {{isset($current->om_customer->addresses->city->name)?$current->om_customer->addresses->city->name:""}},
                    {{isset($current->om_customer->addresses->region->name)?$current->om_customer->addresses->region->name:""}},
                    {{isset($current->om_customer->addresses->country->name)?$current->om_customer->addresses->country->name:""}}
                </div>

            </td>
        </tr>
    </tbody>


    <thead>
        <tr>
            <th colspan="7" class="text-left"><h3>Buyer Detail</h3></th>
            {{-- <th width="20%" class="text-left">Date: {{ $current->date }}</th> --}}
        </tr>
        <tr>
            <th width="16.66%" class="text-left">Membership No.</th>
            <th width="16.66%" class="text-left">Member Name</th>
            <th width="16.66%" class="text-left">S/O,D/O,W/O</th>
            <th width="16.66%" class="text-left">Contact No.</th>
            {{-- <th width="16.66%" class="text-left">Category</th> --}}
            <th width="16.66%" class="text-left">CNIC</th>
            <th width="16.66%" class="text-left">Address</th>

            {{-- <th width="16.66%" class="text-left">Category</th> --}}
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="8">All the detail will be shown which was entered in new member information.</td>
        </tr>
    </tbody>

</table>

<table class="data-table tbl-booking" width="100%" style="margin-top:1%">
    <thead>
        <tr>
            <th colspan="8" style="background-color: #e9e9e9 !important;"><div class="" style="float:left"><h2 class="mb-0">Pictures:</b></div></th>
        </tr>
        <tr>
            <th width="16.66%" class="text-left">Buyer Picture</th>
            <th width="16.66%" class="text-left">Seller Picture</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = $current->nm_image;@endphp
                @if(isset($image_url) && !is_null( $image_url ) && $image_url != "")
                @php $img = $root.'/uploads/'.$image_url; @endphp
                @else
                @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                @endif
                <img id="om_showImage" class="mb-1 center" src="{{ $img }}">
            </td>
            <td>
                @php $root = \Illuminate\Support\Facades\Request::root(); $image_url = $current->om_image;@endphp
                @if(isset($image_url) && !is_null( $image_url ) && $image_url != "")
                @php $img = $root.'/uploads/'.$image_url; @endphp
                @else
                @php $img = asset('assets/images/avatars/blank-img.png') @endphp
                @endif
                <img id="om_showImage" class="mb-1 center" src="{{ $img }}">
            </td>
        </tr>
    </tbody>
</table>

<div class="notes">
    **Membership no. will be generated once for one client, if a client has more than 1 plot or villa at the same time then one membership number will be applied on all files.
    When we put CNIC the membership no will be shown and there would be an option for another entry for client property.
</div>

@endpermission
@endsection
@section('script')
@endsection
