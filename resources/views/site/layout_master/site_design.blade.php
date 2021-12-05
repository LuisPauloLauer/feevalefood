@if(!Session::has('shopCartProduct'))
    <?php $cartProduct = 0; ?>
@else
    <?php $cartProduct = json_encode(Session::get('shopCartProduct')); ?>
@endif
    <!doctype html>
<html lang="pt-br">
<head>
    <script>
        if (window.location.hash && window.location.hash == '#_=_') {
            if (window.history && history.pushState) {
                window.history.pushState("", document.title, window.location.pathname);
            } else {
                // Prevent scrolling by storing the page's current scroll offset
                var scroll = {
                    top: document.body.scrollTop,
                    left: document.body.scrollLeft
                };
                window.location.hash = '';
                // Restore the scroll offset, should be flicker free
                document.body.scrollTop = scroll.top;
                document.body.scrollLeft = scroll.left;
            }
        }
    </script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin/adminLTE/plugins/toastr/toastr.min.css') }}">

</head>
<body>
<div id="app">
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
</div>
<!-- JS Files -->
<!-- jquery -->
<script src="{{ asset('site/node_modules/js/jquery.js') }}"></script>
<!-- vue js app -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- popper -->
<script src="{{ asset('site/node_modules/js/popper.js') }}"></script>
<!-- bootstrap -->
<script src="{{ asset('site/node_modules/js/bootstrap.js') }}"></script>
<!-- bootstrap.bundle -->
<script src="{{ asset('site/node_modules/js/bootstrap.bundle.js') }}"></script>
<!-- JS Files -->

<!-- Toastr -->
<script src="{{ asset('admin/adminLTE/plugins/toastr/toastr.min.js') }}"></script>

<!-- javascript yield -->
@yield('javascript')
<!-- javascript yield -->

<!-- Jquery Plugins, main Jquery -->
<script src="{{ asset('site/node_modules/js/plugins.js') }}"></script>
<script src="{{ asset('site/node_modules/js/active.js') }}"></script>
<script src="{{ asset('site/node_modules/js/plugins-user.js') }}"></script>
<!-- Mask -->
<script src="{{ asset('admin/node_modules/js/jquery.mask.min.js') }}"></script>
<!-- chosen -->
<script src="{{ asset('admin/node_modules/js/chosen.jquery.min.js') }}"></script>
<!-- Jquery Plugins, main Jquery -->
<script>
    $(document).ready(function () {

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $('.phone-mask').mask('(00) 00000-0000');
        $(".chosen-select").chosen({width: "100%"});

        // Add smooth scrolling to all links
        $(".link__ancor__step").on('click', function (event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, function () {
                });
            }
        });

        userdefaultValues.userdefaultValues("{{env('APP_URL')}}");

        @if(Session::has('showModalLoginUser'))
        @if(Session::get('showModalLoginUser'))
        $("body").addClass("modal-open");
        $('#scrollUp').css('display', 'none');

        var accountboxWrapper = $('.accountbox-wrapper');

        $('<div class="body-overlay"></div>').prependTo(accountboxWrapper);

        accountboxWrapper.addClass('is-visible');

        $('.body-overlay').on('click', function () {
            accountboxWrapper.removeClass('is-visible');
            $('#scrollUp').css('display', 'block');
            <?php Session::forget('showModalLoginUser'); ?>
        });

        $('span.accountbox-close-button').on('click', function () {
            accountboxWrapper.removeClass('is-visible');
            $('#scrollUp').css('display', 'block');
            <?php Session::forget('showModalLoginUser'); ?>
        });
        @endif
        @endif

        @if(Session::has('userSiteData'))
        @if(Session::get('userSiteData')['show_modal_adduser'])
        $("body").addClass("modal-open");
        $('#scrollUp').css('display', 'none');

        $(function () {
            $('form[name="formUserSiteCad"]').submit(function (event) {
                event.preventDefault();
                $.ajax({
                    url: "{{ route('usersite.store') }}",
                    type: "post",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response.success === true) {
                            window.location.href = "{{ ( (Session::has('returnurlcallback')) ? url(Session::get('returnurlcallback')) : route('home.index')) }}";
                        } else {
                            $('.addUserMessageBox').removeClass('d-none').html(
                                response.message
                            );
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Erro: ' + xhr.status);
                    },
                });
            })
        });

        var accountboxWrapper = $('.accountbox-wrapper');
        accountboxWrapper.removeClass('is-visible');

        var adduserWrapper = $('.adduser-wrapper');

        $('<div class="body-overlay"></div>').prependTo(adduserWrapper);

        adduserWrapper.addClass('is-visible');


        $('.body-overlay').on('click', function () {
            adduserWrapper.removeClass('is-visible');
            $('.addUserMessageBox').addClass('d-none');
            $('#scrollUp').css('display', 'block');
            $("body").removeClass("modal-open")
            <?php
            //Session::forget('userSiteData');
            Session::put('userSiteData.show_modal_adduser', false);
            ?>
        });

        $('.accountbox-close-button').on('click', function () {
            adduserWrapper.removeClass('is-visible');
            $('.addUserMessageBox').addClass('d-none');
            $('#scrollUp').css('display', 'block');
            $("body").removeClass("modal-open")
            <?php
            //Session::forget('userSiteData');
            Session::put('userSiteData.show_modal_adduser', false);
            ?>
        });
        @endif
        @endif

    });
</script>
</body>
</html>
