<!doctype html>
<html lang="pt-br">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ url('site/images/favicon.ico') }}">
    <title>Delivery - Il Pasticcino</title>
    <!-- CSS Files -->
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('site/node_modules/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('site/node_modules/css/plugins.css') }}">
        <link rel="stylesheet" href="{{ asset('site/node_modules/css/master-style.css') }}">
        <link rel="stylesheet" href="{{ asset('site/node_modules/css/modal-product.css') }}">
        <link rel="stylesheet" href="{{ asset('site/node_modules/css/check-out-product.css') }}">
        <!-- Theme adminlte -->
        <link rel="stylesheet" href="{{ asset('admin/node_modules/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.css') }}">
        <!-- Stylescss yield -->
        @yield('Stylescss')
        <!-- Stylescss yield -->
    <!-- CSS Files -->

    <!-- Modernizer js -->
    <script src="{{ asset('site/node_modules/js/modernizr-3.5.0.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('admin/adminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    @yield('validations_javascript')
    <!-- validations_javascript yield -->

    <!-- Chosen css -->
    <link rel="stylesheet" href="{{ asset('admin/node_modules/css/chosen.min.css') }}">
</head>
<body>
    <div class="wrapper" id="wrapper">
        @if(Route::current()->getName() !== 'cart.checkout')
            @include('site.layout_master.site_header')
        @elseif(Route::current()->getName() === 'cart.checkout')
            @include('site.checkout.header')
        @endif

        @yield('content')

        @if(Route::current()->getName() !== 'cart.checkout')
            @if(Route::current()->getName() !== 'demands.view')
                @include('site.layout_master.site_footer')
            @endif

            @include('site.user.user')

            @include('site.shopcart.cart')
        @endif
    </div>
    <!-- JS Files -->
        <!-- jquery -->
        <script src="{{ asset('site/node_modules/js/jquery.js') }}"></script>
        <!-- vue js app -->
        <script src="{{ asset('js/app.js') }}"></script>
        @if(Route::current()->getName() !== 'cart.checkout')
        <script>
            const cartProduct = new Vue({
                el: '#cart-product'
            });
        </script>
        @endif
        <!-- popper -->
        <script src="{{ asset('site/node_modules/js/popper.js') }}"></script>
        <!-- bootstrap -->
        <script src="{{ asset('site/node_modules/js/bootstrap.js') }}"></script>
        <!-- bootstrap.bundle -->
        <script src="{{ asset('site/node_modules/js/bootstrap.bundle.js') }}"></script>
    <!-- JS Files -->

    <!-- javascript yield -->
    @yield('javascript')
    <!-- javascript yield -->

    <!-- Jquery Plugins, main Jquery -->
    <!-- jquery adminlte
    <script src="{{ asset('admin/node_modules/js/adminlte.js') }}"></script>
    -->
    <script src="{{ asset('site/node_modules/js/plugins.js') }}"></script>
    <script src="{{ asset('site/node_modules/js/active.js') }}"></script>
    <!-- Mask -->
    <script src="{{ asset('admin/node_modules/js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/node_modules/js/chosen.jquery.min.js') }}"></script>
    <!-- Jquery Plugins, main Jquery -->
    <!-- login AddUser -->
    <script>
        $('.phone-mask').mask('(00) 00000-0000');

        @if(Session::has('showModalLoginUser'))
            @if(Session::get('showModalLoginUser'))
                var container = $('.accountbox-wrapper');

                $('<div class="body-overlay"></div>').prependTo(container);

                container.addClass('is-visible');

                $('.body-overlay').on('click', function () {
                    container.removeClass('is-visible');
                    <?php Session::forget('showModalLoginUser'); ?>
                });

                $('span.accountbox-close-button').on('click', function () {
                    container.removeClass('is-visible');
                    <?php Session::forget('showModalLoginUser'); ?>
                });
            @endif
        @endif

        @if(Session::has('userSiteData'))
            @if(Session::get('userSiteData')['show_modal_adduser'])

            $(function () {
                $('form[name="formUserSiteCad"]').submit(function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: "{{ route('usersite.store') }}",
                        type: "post",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function (response) {
                            if(response.success === true){
                                window.location.href = "{{ ( (Session::has('returnurlcallback')) ? url(Session::get('returnurlcallback')) : route('home.index')) }}";
                            }else{
                                $('.addUserMessageBox').removeClass('d-none').html(
                                    response.message
                                );
                            }
                            console.log(response);
                        }
                    });
                })
            });

            $('#idphoneAddUser').mask('(00) 00000-0000');

            $("#idBuildingAddUser").chosen({width: "100%"});

            var container = $('.adduser-wrapper');

            $('<div class="body-overlay"></div>').prependTo(container);

            container.addClass('is-visible');

            $('.body-overlay').on('click', function () {
                container.removeClass('is-visible');
                <?php
                //Session::forget('userSiteData');
                Session::put('userSiteData.show_modal_adduser', false);
                ?>
            });

            $('.accountbox-close-button').on('click', function () {
                container.removeClass('is-visible');
                <?php
                //Session::forget('userSiteData');
                Session::put('userSiteData.show_modal_adduser', false);
                ?>
            });

        @endif
        @endif
    </script>
    <!-- login AddUser -->
</body>
</html>
