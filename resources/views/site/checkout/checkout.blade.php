@extends('site.layout_master.site_design')

@section('content')
    <!-- Start checkOut -->
    <div id="checkout-product">
        <div-checkout-product :listproduct="{{$cartProduct}}" :liststorepayment="{{$listStorePayment}}"></div-checkout-product>
    </div>
    <!-- End checkOut -->
@endsection
