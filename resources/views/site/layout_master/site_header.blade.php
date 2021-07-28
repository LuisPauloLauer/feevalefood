<!-- Start Header Area -->
<header class="htc__header bg--white">
    <!-- Start Mainmenu Area -->
    <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-4 col-md-6 order-1 order-lg-1">
                    <div class="logo">
                        <a href="{{ route('home.index') }}">
                            <img src="{{ url('site/images/logo/foody.png') }}" alt="logo images" width="220">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-4 col-md-2 order-3 order-lg-2">
                    <div class="main__menu__wrap">
                        <nav class="main__menu__nav d-none d-lg-block">
                            <ul class="mainmenu">
                                <li class="drop">
                                    <a href="{{ route('home.index') }}">Home</a>
                                </li>
                                <li class="drop">
                                    <a href="#step1">Como funciona</a>
                                </li>
                                <li class="drop">
                                    <a href="#step2">Cardápio</a>
                                </li>
                                <li class="drop">
                                    <a target="_blank" href="https://www.ilpasticcinocaffe.com/">Blog</a>
                                </li>
                                <li class="drop">
                                    <a href="#contato">Contato</a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
                <div class="col-lg-1 col-sm-4 col-md-4 order-2 order-lg-3">
                    <div class="header__right d-flex justify-content-end">
                        <div class="log__in">
                            @if(Route::current()->getName() === 'usersite.create')
                                <i class="fa text-danger fa-user-plus" style="font-size: 28px"></i>
                            @else
                                @if( Session::has('userSiteLogged') )
                                    <a class="nav-link floating-box__button responsive-header__button" data-toggle="dropdown" href="#">
                                        <i class="fa text-danger fa-user" style="font-size: 28px"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                        <div class="dropdown-item">
                                            <div class="media">
                                                <h3>Olá {{substr(Session::get('userSiteLogged')->name, 0, strpos(Session::get('userSiteLogged')->name, ' '))}}</h3>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('usersite.logout') }}" class="dropdown-item">
                                            <div class="media">
                                                <i class="fa fa-arrow-circle-left" style="margin: 0 15px 0 0"></i>
                                                <h2 class="dropdown-item-title">Sair</h2>
                                            </div>
                                        </a>
                                    </div>
                                @else
                                    <button class="accountbox-trigger btn btn-sm btn-danger">Entrar</button>
                                @endif
                            @endif
                        </div>
                        <div class="shopping__cart">
                            <a class="minicart-trigger" href="#"><i class="fa fa-3x fa-shopping-basket"></i></a>
                            <div class="shop__qun">
                                @if( Session::has('shopCartKit') || Session::has('shopCartProduct') )
                                    @if( Session::has('shopCartKit') && Session::has('shopCartProduct') )
                                        <span id="id-mini-cart-qnt">{{ Session::get('shopCartKit')->totalQty + Session::get('shopCartProduct')->totalQty }}</span>
                                    @elseif( Session::has('shopCartKit') )
                                        <span id="id-mini-cart-qnt">{{ Session::get('shopCartKit')->totalQty }}</span>
                                    @elseif( Session::has('shopCartProduct') )
                                        <span id="id-mini-cart-qnt">{{ Session::get('shopCartProduct')->totalQty }}</span>
                                    @endif
                                @else
                                    <span>0</span>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="mobile-menu d-block d-lg-none"></div>
            <!-- Mobile Menu -->
        </div>
    </div>
    <!-- End Mainmenu Area -->
</header>
<!-- End Header Area -->
