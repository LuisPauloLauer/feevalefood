@extends('site.layout_master.site_design')

@section('content')
    <!-- Modal AddProduct -->
    <div class="modal fade" id="modal-product-view" tabindex="-1" role="dialog" aria-labelledby="modalProductView"
         aria-hidden="true">
        <div class="modal-product-view modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-product-view-content">
                <div class="modal-header modal-product-view-header">
                    <div class="container text-center">
                        <h5 id="modal-product-title" class="modal-product-title"></h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-product-view-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-7">
                                <div id="modal-product-view-img" class="modal-product-view-img">
                                    <img class="img-fluid img-rounded modal-product-img" id="modal-product-img" src=""/>
                                </div>
                                <div id="modal-product-view-img-secunday">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="modal-product-content-info">
                                    <p id="modal-product-description" class="modal-product-description"></p>
                                    <div id="modal-product-price" class="modal-product-price">
                                        <span id="modal-product-price-text" class="modal-product-price-text">

                                        </span>
                                    </div>
                                    <div id="modal-product-content-list" class="modal-product-content-list">
                                    </div>
                                    <div id="modal-product-obs" class="modal-product-obs">
                                        <div id="modal-product-obs-content" class="modal-product-obs-content">
                                            <div id="modal-product-obs-title" class="modal-product-obs-title">
                                                <label id="modal-product-obs-lbl" class="modal-product-obs-lbl">
                                                    Algum comentário?
                                                </label>
                                                <span id="modal-product-obs-span" class="modal-product-obs-span">
                                                    <em class="jQTAreaCount"></em> / <em class="jQTAreaValue"></em>
                                                </span>
                                            </div>
                                            <textarea name="observation" id="modal-product-obs-txt" class="modal-product-obs-txt" maxlength="150" tabindex="0" placeholder="Deixe instruções especiais"></textarea>
                                            <p class="jQTAreaExt"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="dish-content__action">
                        <div class="dish-action">
                            <div class="dish-tooltip">
                                <div class="dish-action__add-wrapper">
                                    <div class="dish-action__counter">
                                        <div class="marmita-counter">
                                            <button id="btn-model-minus-car-qnty" type="button" class="btn btn-outline-danger btn-icon">
                                                <span class="glyphicon fa fa-minus"></span>
                                            </button>
                                            <div id="qntyProdCart" class="marmita-counter__value"></div>
                                            <button id="btn-model-add-car-qnty" type="button" class="btn btn-outline-danger btn-icon"><span
                                                    class="glyphicon fa fa-plus"></span></button>
                                        </div>
                                    </div>
                                    <button id="btn-model-add-car" class="btn btn-danger btn--default btn--size-m">
                                        <div class="dish-action__add-button">
                                            <span id="btn-model-add-car-texto">Adicionar</span>
                                            <span id="btn-model-add-car-price"></span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Modal AddProduct -->

    <!-- Start Slider1 Area -->
    <div class="slider__area slider--three">
        <div class="slider__activation--1">
            <!-- Start Single Slide -->
            <div class="slide fullscreen bg-image--1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="slider__content">
                                <div class="slider__inner">
                                    <h2>Seja bem-vindo a</h2>
                                    <h1>“Il Pasticcino”</h1>
                                    <div class="slider__btn">
                                        <a class="food__btn" target="_blank" href="https://www.ilpasticcinocaffe.com">Saiba
                                            mais</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Slide -->
        </div>
    </div>
    <!-- End Slider1 Area -->

    <!-- Start Service Area -->
    <section id="step1" class="fd__service__area bg-image--2 section-padding--sm">
        <div class="container">
            <div class="service__wrapper bg--white">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="section__title service__align--left">
                            <p>O nosso serviço</p>
                            <h2 class="title__line">Como funciona</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt--30">
                    <!-- Start Single Service -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="service">
                            <div class="service__title">
                                <div class="ser__icon">
                                    <img src="{{ url('site/images/icon/color-icon/1.png') }}" alt="icon image">
                                </div>
                                <h2><a href="#step2">Veja o cardápio</a></h2>
                            </div>
                            <div class="service__details">
                                <p>Selecione as variedades do cardápio e adicione no carrinho de compras.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Service -->
                    <!-- Start Single Service -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="service">
                            <div class="service__title">
                                <div class="ser__icon">
                                    <img src="{{ url('site/images/icon/color-icon/2.png') }}" alt="icon image">
                                </div>
                                <h2 class="text-danger">Faça o pagamento</h2>
                            </div>
                            <div class="service__details">
                                <p>Faço o pagamento de acordo com as opções de pagamento.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Service -->
                    <!-- Start Single Service -->
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="service">
                            <div class="service__title">
                                <div class="ser__icon">
                                    <img src="{{ url('site/images/icon/color-icon/3.png') }}" alt="icon image">
                                </div>
                                <h2 class="text-danger">Aguarde a sua entrega</h2>
                            </div>
                            <div class="service__details">
                                <p>Entrega será feita após confirmação do pagamento.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Service Area -->

    <!-- Start Special Menu -->
    <section id="step2" class="fd__special__menu__area bg-white section-padding--sm">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="section__title service__align--left">
                        <p>Escolha as opções do</p>
                        <h2 class="title__line">Cardápio</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="special__food__menu mt--30">
            <div class="food__menu__prl bg-white">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $countCP = 0 ?>
                            <div class="food__nav nav nav-tabs" role="tablist">
                                @foreach($listCategoriesProducts as $CategoryProducts)
                                    @if($countCP < 1)
                                        <a class="active" id="nav-{{$CategoryProducts->id}}-tab" data-toggle="tab"
                                           href="#nav-{{$CategoryProducts->id}}"
                                           role="tab">{{$CategoryProducts->name}}</a>
                                    @else
                                        <a id="nav-{{$CategoryProducts->id}}-tab" data-toggle="tab"
                                           href="#nav-{{$CategoryProducts->id}}"
                                           role="tab">{{$CategoryProducts->name}}</a>
                                    @endif
                                    <?php $countCP++ ?>
                                @endforeach
                            </div>
                            <?php $countCP = 0 ?>
                            <div class="fd__tab__content tab-content" id="nav-tabContent">
                                @foreach($listCategoriesProducts as $CategoryProducts)
                                    <?php
                                    $KitsbyCategory = $CategoryProducts::find($CategoryProducts->id)->pesqKitsByCategoriesProduct($Store, 'S', true)->get();
                                    $ProductsByCategory = $CategoryProducts::find($CategoryProducts->id)->pesqProductsByCategoriesProduct($Store, 'S')->get();
                                    $quntyKitsByDiv = (count($KitsbyCategory) / 2);
                                    $quntyProductsByDiv = (count($ProductsByCategory) / 2);
                                    $totalItensByDiv = $quntyKitsByDiv + $quntyProductsByDiv;
                                    ?>
                                    @if($countCP < 1)
                                        <div class="single__tab__panel tab-pane fade show active"
                                             id="nav-{{$CategoryProducts->id}}" role="tabpanel">
                                            <div class="tab__content__wrap">
                                                <div class="row single__tab__content">
                                                    @if(count($KitsbyCategory) > 0)
                                                        @foreach($listKit as $Kit)
                                                            @if($CategoryProducts->id == $Kit->category_product)
                                                                <div class="col-md-6 food__menu">
                                                                    <div class="food__menu__thumb">
                                                                        <a href="" class="view-product-info d-flex" data-object="kit" data-prodid="{{$Kit->id}}">
                                                                            @if($Kit::find($Kit->id)->pesqFirstImageKit)
                                                                                <img src="{{ $pathImagens }}/kits/store_id_{{$Store->id}}/{{ $Kit->id}}/small/{{ $Kit::find($Kit->id)->pesqFirstImageKit->path_image }}" alt="product images"/>
                                                                            @else
                                                                                <img src="{{ $pathImagens }}/../../files/images/no_photo.png" alt="product images"/>
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="container food__menu__details">
                                                                        <div class="fd__menu__title__prize">
                                                                            <h4>
                                                                                <a href="" class="view-product-info d-flex" data-object="kit" data-prodid="{{$Kit->id}}">
                                                                                    {{$Kit->name}}
                                                                                </a>
                                                                            </h4>
                                                                            <span class="menu__prize">
                                                                            {{($Kit->unit_promotion_price > 0 ? 'R$'.number_format($Kit->unit_promotion_price,2,",",".") : 'R$'.number_format($Kit->unit_price,2,",","."))}}
                                                                        </span>
                                                                        </div>
                                                                        <div class="fd__menu__details">
                                                                            <span>{{ (strlen($Kit->description) > 100) ? substr($Kit->description,0,100).'...' : $Kit->description}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if(count($ProductsByCategory) > 0)
                                                        @foreach($listProduct as $Product)
                                                            @if($CategoryProducts->id == $Product->category_product)
                                                                <div class="col-md-6 food__menu">
                                                                    <div class="food__menu__thumb">
                                                                        <a href="" class="view-product-info d-flex" data-object="product" data-prodid="{{$Product->id}}">
                                                                            @if($Product::find($Product->id)->pesqFirstImageProduct)
                                                                                <img src="{{ $pathImagens }}/products/store_id_{{$Store->id}}/{{ $Product->id}}/small/{{ $Product::find($Product->id)->pesqFirstImageProduct->path_image }}" alt="product images"/>
                                                                            @else
                                                                                <img src="{{ $pathImagens }}/../../files/images/no_photo.png" alt="product images"/>
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="container food__menu__details">
                                                                        <div class="fd__menu__title__prize">
                                                                            <h4>
                                                                                <a href="" class="view-product-info d-flex" data-object="product" data-prodid="{{$Product->id}}">
                                                                                    {{$Product->name}}
                                                                                </a>
                                                                            </h4>
                                                                            <span class="menu__prize">
                                                                            {{($Product->unit_promotion_price > 0 ? 'R$'.number_format($Product->unit_promotion_price,2,",",".") : 'R$'.number_format($Product->unit_price,2,",","."))}}
                                                                        </span>
                                                                        </div>
                                                                        <div class="fd__menu__details">
                                                                            <span>{{ (strlen($Product->description) > 100) ? substr($Product->description,0,100).'...' : $Product->description}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="single__tab__panel tab-pane fade"
                                             id="nav-{{$CategoryProducts->id}}" role="tabpanel">
                                            <div class="tab__content__wrap">
                                                <div class="row single__tab__content">
                                                    @if(count($KitsbyCategory) > 0)
                                                        @foreach($listKit as $Kit)
                                                            @if($CategoryProducts->id == $Kit->category_product)
                                                                <div class="col-md-6 food__menu">
                                                                    <div class="food__menu__thumb">
                                                                        <a href="" class="view-product-info d-flex" data-object="kit" data-prodid="{{$Kit->id}}">
                                                                            @if($Kit::find($Kit->id)->pesqFirstImageKit)
                                                                                <img
                                                                                    src="{{ $pathImagens }}/kits/store_id_{{$Store->id}}/{{ $Kit->id}}/small/{{ $Kit::find($Kit->id)->pesqFirstImageKit->path_image }}"
                                                                                    alt="product images" width="105"
                                                                                    height="109"/>
                                                                            @else
                                                                                <img
                                                                                    src="{{ $pathImagens }}/../../files/images/no_photo.png"
                                                                                    alt="product images" width="105"
                                                                                    height="109"/>
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="container food__menu__details">
                                                                        <div class="fd__menu__title__prize">
                                                                            <h4>
                                                                                <a href="" class="view-product-info d-flex" data-object="kit" data-prodid="{{$Kit->id}}">
                                                                                    {{$Kit->name}}
                                                                                </a>
                                                                            </h4>
                                                                            <span class="menu__prize">
                                                                            {{($Kit->unit_promotion_price > 0 ? 'R$'.number_format($Kit->unit_promotion_price,2,",",".") : 'R$'.number_format($Kit->unit_price,2,",","."))}}
                                                                        </span>
                                                                        </div>
                                                                        <div class="fd__menu__details">
                                                                            <span>{{ (strlen($Kit->description) > 100) ? substr($Kit->description,0,100).'...' : $Kit->description}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @if(count($ProductsByCategory) > 0)
                                                        @foreach($listProduct as $Product)
                                                            @if($CategoryProducts->id == $Product->category_product)
                                                                <div class="col-md-6 food__menu">
                                                                    <div class="food__menu__thumb">
                                                                        <a href="" class="view-product-info d-flex" data-object="product" data-prodid="{{$Product->id}}">
                                                                            @if($Product::find($Product->id)->pesqFirstImageProduct)
                                                                                <img
                                                                                    src="{{ $pathImagens }}/products/store_id_{{$Store->id}}/{{ $Product->id}}/small/{{ $Product::find($Product->id)->pesqFirstImageProduct->path_image }}"
                                                                                    alt="product images" width="105"
                                                                                    height="109"/>
                                                                            @else
                                                                                <img
                                                                                    src="{{ $pathImagens }}/../../files/images/no_photo.png"
                                                                                    alt="product images" width="105"
                                                                                    height="109"/>
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="container food__menu__details">
                                                                        <div class="fd__menu__title__prize">
                                                                            <h4>
                                                                                <a href="" class="view-product-info d-flex" data-object="product" data-prodid="{{$Product->id}}">
                                                                                    {{$Product->name}}
                                                                                </a>
                                                                            </h4>
                                                                            <span class="menu__prize">
                                                                            {{($Product->unit_promotion_price > 0 ? 'R$'.number_format($Product->unit_promotion_price,2,",",".") : 'R$'.number_format($Product->unit_price,2,",","."))}}
                                                                        </span>
                                                                        </div>
                                                                        <div class="fd__menu__details">
                                                                            <span>{{ (strlen($Product->description) > 100) ? substr($Product->description,0,100).'...' : $Product->description}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <?php $countCP++ ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Special Menu -->

    <!-- Start Testimonail Area -->
    <section class="fd__testimonial__area testimonial--2 bg-image--9 ptb--100">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="fd__testimonial__container testimonial__activation--2">
                        <!-- Start Single Testimonial -->
                        <div class="single__testimonial d-flex justify-content-between flex-wrap">
                            <!-- Start Testimonial -->
                            <div class="testimonial-2">
                                <p>Produtos deliciosos! Super recomendo e chegou em 15min</p>
                                <div class="fd__test__info">
                                    <h6>Jennifer disse em 22/06/2021</h6>
                                    <span>iFood</span>
                                </div>
                            </div>
                            <!-- End Testimonial -->
                            <!-- Start Testimonial -->
                            <div class="testimonial-2">
                                <p>Me surpreendeu com o sabor, simplesmente maravilhoso!!! Parabéns</p>
                                <div class="fd__test__info">
                                    <h6>Vinicius disse em 26/03/2021</h6>
                                    <span>iFood</span>
                                </div>
                            </div>
                            <!-- End Testimonial -->
                        </div>
                        <!-- End Single Testimonial -->
                        <!-- Start Single Testimonial -->
                        <div class="single__testimonial d-flex justify-content-between flex-wrap">
                            <!-- Start Testimonial -->
                            <div class="testimonial-2">
                                <p>Croissant primavera é incrível! O 🥐 por si só já é perfeito, nesse sanduíche ficou sensacional! Parabéns!</p>
                                <div class="fd__test__info">
                                    <h6>Luciana disse em 06/03/2021</h6>
                                    <span>iFood</span>
                                </div>
                            </div>
                            <!-- End Testimonial -->
                            <!-- Start Testimonial -->
                            <div class="testimonial-2">
                                <p>Sempre perfeito!!!</p>
                                <div class="fd__test__info">
                                    <h6>Maria disse em 14/03/2021</h6>
                                    <span>iFood</span>
                                </div>
                            </div>
                            <!-- End Testimonial -->
                        </div>
                        <!-- End Single Testimonial -->
                        <!-- Start Single Testimonial -->
                        <div class="single__testimonial d-flex justify-content-between flex-wrap">
                            <!-- Start Testimonial -->
                            <div class="testimonial-2">
                                <p>Produto muito bom, de qualidade, saboroso, com certeza uma pedacinho da Itália aqui no RS</p>
                                <div class="fd__test__info">
                                    <h6>Helder disse em 30/01/2021</h6>
                                    <span>iFood</span>
                                </div>
                            </div>
                            <!-- End Testimonial -->
                            <!-- Start Testimonial -->
                            <div class="testimonial-2">
                                <p>Doces e salgados super caprichados, amamos!</p>
                                <div class="fd__test__info">
                                    <h6>Deise disse em 31/01/2021</h6>
                                    <span>iFood</span>
                                </div>
                            </div>
                            <!-- End Testimonial -->
                        </div>
                        <!-- End Single Testimonial -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonail Area -->

    <!-- Start More Saled Itens Area -->
    <section class="food__category__area section-padding--md2 bg--white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="section__title service__align--left">
                        <p>Aqui está os</p>
                        <h2 class="title__line">Mais pedidos</h2>
                    </div>
                </div>
            </div>
            <div class="food__category__wrapper mt--40">
                <div class="row">
                    @foreach($listMoreSaleKit as $saleKit)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="food__item foo">
                                <div class="food__thumb">
                                    <a href="" class="view-product-info d-flex" data-object="kit"
                                       data-prodid="{{$saleKit->id}}">
                                        @if($saleKit::find($saleKit->id)->pesqFirstImageKit)
                                            <img class="img-fluid img-rounded" src="{{ $pathImagens }}/kits/store_id_{{$Store->id}}/{{ $saleKit->id}}/medium/{{ $saleKit::find($saleKit->id)->pesqFirstImageKit->path_image }}" alt="product images">
                                        @else
                                            <img class="img-fluid img-rounded" src="{{ $pathImagens }}/../../files/images/no_photo.png" alt="product images">
                                        @endif
                                    </a>
                                </div>
                                <div class="food__title">
                                    <h2>
                                        <a href="" class="view-product-info" data-object="kit" data-prodid="{{$saleKit->id}}">{{$saleKit->name}}</a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach($listMoreSaleProduct as $saleProduct)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="food__item foo">
                                <div class="food__thumb">
                                    <a href="" class="view-product-info d-flex" data-object="product"
                                       data-prodid="{{$saleProduct->id}}">
                                        @if($saleProduct::find($saleProduct->id)->pesqFirstImageProduct)
                                            <img class="img-fluid img-rounded" src="{{ $pathImagens }}/products/store_id_{{$Store->id}}/{{ $saleProduct->id}}/medium/{{ $saleProduct::find($saleProduct->id)->pesqFirstImageProduct->path_image }}" alt="product images">
                                        @else
                                            <img class="img-fluid img-rounded" src="{{ $pathImagens }}/../../files/images/no_photo.png" alt="product images">
                                        @endif
                                    </a>
                                </div>
                                <div class="food__title">
                                    <h2>
                                        <a href="" class="view-product-info" data-object="product" data-prodid="{{$saleProduct->id}}">{{$saleProduct->name}}</a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End More Saled Itens Area -->

    <!-- Start Subscribe Area -->
    <section class="fd__subscribe__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="subscribe__inner">
                        <!-- News Letter off
                        <h2>Se inscreva na nossa newsletter</h2>
                        <div id="mc_embed_signup">
                            <div id="enter__email__address">
                                <form
                                    action="#"
                                    method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
                                    class="validate" target="_blank" novalidate>
                                    <div id="mc_embed_signup_scroll" class="htc__news__inner">
                                        <div class="news__input">
                                            <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL"
                                                   placeholder="Insira seu email aqui" required>
                                        </div>
                                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input
                                                type="text" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" tabindex="-1"
                                                value=""></div>
                                        <div class="clearfix subscribe__btn"><input type="submit" value="Enviar"
                                                                                    name="subscribe"
                                                                                    id="mc-embedded-subscribe"
                                                                                    class="sign__up food__btn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Subscribe Area -->
@endsection

@section('javascript')
    <script src="{{ asset('site/node_modules/js/plugin-jqtarea.js') }}"></script>
    <script>
        @if ($message = Session::get('messageCheckOut'))
            alert('{{$message}}');
        @endif

        var modalProductObject = null;
        var modalProductId = null;
        var modalProductQnty = 0;
        var modalProductPrice = 0;
        var modalProductTotalPrice = 0;
        var modalCategoryTotal = 0;
        var modalSellProducts = [];

        function formatPrice(itemPriceValue) {
            let val = (itemPriceValue / 1).toFixed(2).replace('.', ',');
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        };

        $("#modal-product-obs-txt").jQTArea({
            setLimit: 150,
            setExt: "W",
            setExtR: true
        });

        $(document).on("click", ".cart-kit-prod-item", function (event) {

            var div = $("div#modal-product-content-list");
            var radiosBtns = div.find("input[type='radio']");
            var numbRadiosChecked = 0;
            modalSellProducts = [];

            // Get all the radios
            for (var i = 0; i < radiosBtns.length; i++) {

                var radio = $(radiosBtns[i]);

                // If this isn't checked, skip it
                if (radio.is(':checked') === true) {
                    modalSellProducts.push(radio.val());
                    numbRadiosChecked++;
                    $('#itensSelectedbykit').empty();
                    $('#itensSelectedbykit').text(numbRadiosChecked + '/' + modalCategoryTotal);
                }
            }

            if (numbRadiosChecked == modalCategoryTotal) {
               // console.log(modalSellProducts);
               // console.log('Obs: ' + $('#idobservationtxt').val());
                $('#btn-model-add-car').prop("disabled", false);
            }

        });

        $(document).on("click", "#btn-model-add-car-qnty", function (event) {

            var ProductTotalPrice = 0;

            if (modalProductQnty >= 1) {
                modalProductTotalPrice = parseFloat(modalProductTotalPrice);
                modalProductPrice = parseFloat(modalProductPrice);
                modalProductQnty++;
                modalProductTotalPrice += modalProductPrice;

                ProductTotalPrice = modalProductTotalPrice.toFixed(2);


                //$('#btn-model-add-car').empty();
                //$('#btn-model-add-car').text('Adicionar R$ ');
                //$('#btn-model-add-car').append('<median>' + ProductTotalPrice + '<median>');
                $('#btn-model-add-car-price').empty();
                $('#btn-model-add-car-price').text('R$ '+formatPrice(ProductTotalPrice));
                $('#qntyProdCart').empty();
                $('#qntyProdCart').text(modalProductQnty);

                $('#btn-model-minus-car-qnty').prop("disabled", false);
            }

        });

        $(document).on("click", "#btn-model-minus-car-qnty", function (event) {

            var ProductTotalPrice = 0;

            if (modalProductQnty > 1) {
                modalProductTotalPrice = parseFloat(modalProductTotalPrice);
                modalProductPrice = parseFloat(modalProductPrice);
                modalProductQnty = (modalProductQnty - 1);
                modalProductTotalPrice = (modalProductTotalPrice - modalProductPrice);

                ProductTotalPrice = modalProductTotalPrice.toFixed(2);

                //$('#btn-model-add-car').empty();
                //$('#btn-model-add-car').text('Adicionar R$ ');
                //$('#btn-model-add-car').append('<median>' + ProductTotalPrice + '<median>');
                $('#btn-model-add-car-price').empty();
                $('#btn-model-add-car-price').text('R$ '+formatPrice(ProductTotalPrice));
                $('#qntyProdCart').empty();
                $('#qntyProdCart').text(modalProductQnty);

                if (modalProductQnty == 1) {
                    $('#btn-model-minus-car-qnty').prop("disabled", true);
                }

            }

        });

        $(document).on("click", "#btn-model-add-car", function (event) {

            event.preventDefault();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('cart.add.item') }} ",
                type: "post",
                data: {
                    product_object: modalProductObject,
                    product_id: modalProductId,
                    product_qnty: $('#qntyProdCart').text(),
                    product_observation: $('#modal-product-obs-txt').val(),
                    products_sell: modalSellProducts
                },
                dataType: "json",
                success: function (data) {
                    if (data.success === true) {

                        //location.reload(true);
                        //window.location.reload();
                        document.location.reload(true);

                    } else {
                        alert(data.success);
                    }

                //    console.log(data);
                }
            });

        });

        function showAddProductModal(dataProduct) {

            $('#scrollUp').css('display','none');

            if (dataProduct.object == 'kit') {
                modalCategoryTotal = dataProduct.products_category.length;
            }

            var modalCategoryProduct = null;
            modalProductObject = null;
            modalProductId = null;
            modalProductQnty = 0;
            modalProductPrice = 0;
            modalProductTotalPrice = 0;

            if (dataProduct.imagens[0]) {
                if (dataProduct.object == 'kit') {
                    var firstImage = '{{ $pathImagens }}/kits/store_id_{{ $Store->id }}/' + dataProduct.id + '/medium/' + dataProduct.imagens[0]['path_image'];
                } else if (dataProduct.object == 'product') {
                    var firstImage = '{{ $pathImagens }}/products/store_id_{{ $Store->id }}/' + dataProduct.id + '/medium/' + dataProduct.imagens[0]['path_image'];
                }
            } else {
                var firstImage = '{{ $pathImagens }}/../../files/images/no_photo.png';
            }

            $('#modal-product-view').modal('show');

            modalProductObject = dataProduct.object;
            modalProductId = dataProduct.id;
            modalProductQnty = 1;

            if (dataProduct.unit_promotion_price > 0) {
                modalProductPrice = dataProduct.unit_promotion_price;
                modalProductTotalPrice = dataProduct.unit_promotion_price;
            } else {
                modalProductPrice = dataProduct.unit_price;
                modalProductTotalPrice = dataProduct.unit_price;
            }

            $('#btn-model-minus-car-qnty').prop("disabled", true);

            $('#modal-product-title').text(dataProduct.nameproduct);
            $('#modal-product-description').text(dataProduct.description);
            $('#qntyProdCart').text(1);
            $('#btn-model-add-car-price').empty();

            if (dataProduct.unit_promotion_price > 0) {
                $('#btn-model-add-car-price').text('R$ '+formatPrice(dataProduct.unit_promotion_price));
                $('#modal-product-price-text').text('R$ '+formatPrice(dataProduct.unit_promotion_price));
            } else {
                $('#btn-model-add-car-price').text('R$ '+formatPrice(dataProduct.unit_price));
                $('#modal-product-price-text').text('R$ '+formatPrice(dataProduct.unit_price));
            }

            if (dataProduct.object == 'kit') {
                $('#btn-model-add-car').prop("disabled", true);
            } else {
                $('#btn-model-add-car').prop("disabled", false);
            }

            $('#modal-product-img').attr("src", firstImage);

            $('#modal-product-view-img-secunday').empty();

            $('#modal-product-content-list').empty();

            if (dataProduct.imagens.length > 1) {

                var numbImagens;

                for (numbImagens = 0; numbImagens < dataProduct.imagens.length; numbImagens++) {

                    if (dataProduct.object == 'kit') {
                        var imageUrl = '{{ $pathImagens }}/kits/store_id_{{ $Store->id }}/' + dataProduct.id + '/small/' + dataProduct.imagens[numbImagens]['path_image'];
                    } else if (dataProduct.object == 'product') {
                        var imageUrl = '{{ $pathImagens }}/products/store_id_{{ $Store->id }}/' + dataProduct.id + '/small/' + dataProduct.imagens[numbImagens]['path_image'];
                    }

                    $('#modal-product-view-img-secunday').append('<img width="70" height="70" class="img-thumbnail mt--15 mr--8 modal-product-img-index-' + numbImagens + '" src="' + imageUrl + '">');

                }
            }

            if (dataProduct.object == 'kit') {
                var numbProducts;
                var numbCategory;
                $('#modal-product-content-list').append('<div id="itensSelectedbykit"> 0/' + modalCategoryTotal + ' </div><br>');
                for (numbProducts = 0; numbProducts < dataProduct.products.length; numbProducts++) {

                    if (modalCategoryProduct != dataProduct.products[numbProducts]['category_product']) {
                        for (numbCategory = 0; numbCategory < dataProduct.products_category.length; numbCategory++) {
                            if (dataProduct.products[numbProducts]['category_product'] == dataProduct.products_category[numbCategory]['products_category_id']) {
                                $('#modal-product-content-list').append('<strong>' + dataProduct.products_category[numbCategory]['products_category_name'] + ' </strong><br>');
                            }
                        }
                    }

                    $('#modal-product-content-list').append('<input type="radio" class="cart-kit-prod-item" id="cart-kit-prod-' + numbProducts + '" name="cart_kit_prod_' + dataProduct.products[numbProducts]['category_product'] + '" value="' + dataProduct.products[numbProducts]['id'] + '">');
                    $('#modal-product-content-list').append('<label for="cart-kit-prod-' + numbProducts + '"> ' + dataProduct.products[numbProducts]['name'] + ' </label><br>');

                    modalCategoryProduct = dataProduct.products[numbProducts]['category_product'];
                }
            }
        }

        $(document).on("click", ".view-product-info", function (event) {

            event.preventDefault();
            var product_object = $(this).data("object");
            var product_id = $(this).data("prodid");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('product.showmodal') }}",
                type: "post",
                data: {
                    product_object: product_object,
                    product_id: product_id,
                    store_id: {{$Store->id}},
                    empty_cart: null
                },
                dataType: "json",
                success: function (data) {
                    if (data.success === true) {

                        showAddProductModal(data);

                    } else if (data.message == 'diffstore') {

                        $('#diffStoreModal').modal('show');

                        $(document).on("click", "#emptyCartModalProduct", function (event) {

                            event.preventDefault();

                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "{{ route('product.showmodal') }} ",
                                type: "post",
                                data: {
                                    product_object: product_object,
                                    product_id: product_id,
                                    store_id: {{$Store->id}},
                                    empty_cart: true
                                },
                                dataType: "json",
                                success: function (data) {
                                    if (data.success === true) {

                                        $('#diffStoreModal').modal('hide');
                                        showAddProductModal(data);

                                    } else {
                                        alert(data.message)
                                    }

                            //        console.log(data);

                                }

                            });

                        });

                    } else {
                        alert(data.message)
                    }

                //    console.log(data);

                }

            });

        });

        $('#modal-product-view').on('hidden.bs.modal', function () {
            $('#scrollUp').css('display','block');
            $('#modal-product-obs-txt').val('');
        });
    </script>
@endsection
