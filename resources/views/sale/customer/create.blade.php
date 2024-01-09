@extends('layouts.form')
@section('title', $data['title'])
@section('style')
@endsection

@section('content')

    @include('sale.customer.form')

@endsection

@section('pageJs')
    @yield('pageJsScript')
@endsection

@section('script')
    @yield('scriptCustom')
@endsection

