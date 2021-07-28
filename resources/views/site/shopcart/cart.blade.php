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
<!-- Start Cartbox -->
<div id="cart-product">
    <div-cart-product :listproduct="{{$cartProduct}}" :appurl="{{$appUrl}}"></div-cart-product>
</div>
<!-- End Cartbox -->
