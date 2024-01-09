<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'HZ Traders') }}</title>
    <link rel="apple-touch-icon" href="{{asset('assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.min.css')}}">
    <!-- END: Vendor CSS-->
    @yield('themeStyle')
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/extensions/ext-component-toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/pickers/form-flat-pickr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/pickers/form-pickadate.css')}}">

    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <!-- END: Custom CSS-->
    @if(isset($data['view']) && $data['view'])
        <style>
            input[type='text'],.select2 {
                pointer-events:none !important;
                color:#000 !important;
                background:#F5F5F5 !important;
            }
            .select2-selection{
                background:#F5F5F5 !important;
            }
        </style>
    @endif
    @yield('style')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">


@include('elements.header')
@include('elements.sidebar')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    @yield('content')
</div>
<!-- END: Content-->

<script>
    var routeGetProductDetail = '{{ route('sale.sale-invoice.getProductDetail') }}';
</script>
<!-- BEGIN: Vendor JS-->
<script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<!-- END: Page Vendor JS-->
<script src="{{asset('assets/vendors/js/jquery/jquery.min.js')}}"></script>

<!-- BEGIN: Theme JS-->
<script src="{{asset('assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/js/core/app.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{asset('assets/js/scripts/forms/form-validation.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/pickers/form-pickers.js')}}"></script>


@include('layouts.pageSetting')

@yield('pageJs')
<!-- END: Page JS-->

@yield('script')

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
    function valueEmpty(val){
        if(val == 0 || val == undefined || val == "" || val == null || val == NaN || val == 'NaN' || !val){
            return true;
        }
        return false;
    }

    $(document).on('change','.countryList',function(){
        var validate = true;
        var thix = $(this);
        var val = thix.find('option:selected').val();
        if(valueEmpty(val)){
            $('form').find('.cityList').html("<option value='0' selected>Select</option>");
            $('form').find('.regionList').html("<option value='0' selected>Select</option>");
            validate = false;
            return false;
        }
        if(validate){
            var formData = {
                country_id : val
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('setting.region.getRegionsByCountry') }}',
                dataType	: 'json',
                data        : formData,
                success: function(response,data) {
                    if(response.status == 'success'){
                        var regions = response.data['regions'];
                        var length = regions.length;
                        var options = "<option value='0' selected>Select</option>";
                        for(var i=0;i<length;i++){
                            if(regions[i]['name']){
                                options += '<option value="'+regions[i]['id']+'">'+regions[i]['name']+'</option>';
                            }
                        }
                        $('form').find('.regionList').html(options);
                    }else{
                        ntoastr.error(response.message);
                    }
                },
                error: function(response,status) {
                    ntoastr.error('server error..404');
                }
            });
        }
    });
    $(document).on('change','.regionList',function(){
        var validate = true;
        var thix = $(this);
        var val = thix.find('option:selected').val();
        var country_id = $('form').find('.countryList option:selected').val();
        if(valueEmpty(country_id)){
            ntoastr.error("Select country");
            validate = false;
            return false;
        }
        if(valueEmpty(val)){
            $('form').find('.cityList').html("<option value='0' selected>Select</option>");
            validate = false;
            return false;
        }
        if(validate){
            var formData = {
                country_id : country_id,
                region_id : val
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('setting.city.getCityByRegion') }}',
                dataType	: 'json',
                data        : formData,
                success: function(response,data) {
                    if(response.status == 'success'){
                        var cities = response.data['cities'];
                        var length = cities.length;
                        var options = "<option value='0' selected>Select</option>";
                        for(var i=0;i<length;i++){
                            if(cities[i]['name']){
                                options += '<option value="'+cities[i]['id']+'">'+cities[i]['name']+'</option>';
                            }
                        }
                        $('form').find('.cityList').html(options);
                    }else{
                        ntoastr.error(response.message);
                    }
                },
                error: function(response,status) {
                    ntoastr.error('server error..404');
                }
            });
        }
    });
    $(document).on('change','.parentCategoryList',function(){
        var validate = true;
        var thix = $(this);
        var val = thix.find('option:selected').val();
        if(valueEmpty(val)){
            ntoastr.error("Select country");
            validate = false;
            return false;
        }
        if(validate){
            var formData = {
                parent_id : val
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '{{ route('purchase.category.getChildByParentCategory') }}',
                dataType	: 'json',
                data        : formData,
                success: function(response,data) {
                    if(response.status == 'success'){
                        var child = response.data['child'];
                        var length = child.length;
                        var options = "<option value='0' selected>Select</option>";
                        for(var i=0;i<length;i++){
                            if(child[i]['name']){
                                options += '<option value="'+child[i]['id']+'">'+child[i]['name']+'</option>';
                            }
                        }
                        $('form').find('.childCategoryList').html(options);
                    }else{
                        ntoastr.error(response.message);
                    }
                },
                error: function(response,status) {
                    ntoastr.error('server error..404');
                }
            });
        }
    });
</script>
@include('layouts.commonJSFunc')

<script src="{{asset('/pages/common/validateInputFields.js')}}"></script>
</body>
<!-- END: Body-->

</html>
