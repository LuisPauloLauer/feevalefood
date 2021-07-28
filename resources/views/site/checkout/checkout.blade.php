@extends('site.layout_master.site_design')

@section('content')
    @if(!Session::has('shopCartProduct'))
        <?php
        $cartProduct = 0;
        $appUrl =  json_encode(env('APP_URL'));
        ?>
    @else
        <?php
        $cartProduct =  json_encode(Session::get('shopCartProduct'));
        $appUrl =  json_encode(env('APP_URL'));
        //$cartProductDump = Session::get('shopCartProduct');
        //dd($cartProductDump);
        ?>
    @endif
    <!-- Start checkOut -->
    <div id="checkout-product">
        <div-checkout-product :listproduct="{{$cartProduct}}" :liststorepayment="{{$listStorePayment}}" :appurl="{{$appUrl}}"></div-checkout-product>
    </div>
    <!-- End checkOut -->
@endsection
@section('javascript')
    <script>
        const checkoutProduct = new Vue({
            el: '#checkout-product'
        });
    </script>
@endsection
