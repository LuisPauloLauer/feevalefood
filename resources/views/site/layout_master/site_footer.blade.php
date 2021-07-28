<!-- Start Footer Area -->
<footer id="contato" class="footer__area footer--1">
    <div class="footer__wrapper bg__cat--1 section-padding--lg">
        <div class="container">
            <div class="row">
                <!-- Start Single Footer -->
                <div class="col-md-6 col-lg-3 col-sm-12">
                    <div class="footer">
                        <h2 class="ftr__title">Sobre {{$Store->name}}</h2>
                        <div class="footer__inner">
                            <div class="ftr__details">
                                <p>{{$Store->description}}</p>
                                <div class="ftr__address__inner">
                                    <div class="ftr__address">
                                        <div class="ftr__address__icon">
                                            <i class="fa fa-map-marker"></i>
                                        </div>
                                        <div class="frt__address__details">
                                            <p>Rua: {{$Store->street}} Nº {{$Store->number}}</p>
                                            <p>Cep: {{$Store->zip_code}} Cidade: {{$Store::find($Store->id)->pesqCity->name}}</p>
                                        </div>
                                    </div>
                                    <div class="ftr__address">
                                        <div class="ftr__address__icon">
                                            <i class="fa fa-whatsapp"></i>
                                        </div>
                                        <div class="frt__address__details">
                                            <p><a target="_blank" title="WhatsApp" href="https://api.whatsapp.com/send?l=pt_br&phone=55{{(($Store->fone_store_site) ? $Store->fone_store_site : $Store->fone1)}}"><span class="phone-mask">{{(($Store->fone_store_site) ? $Store->fone_store_site : $Store->fone1)}}</span></a></p>
                                        </div>
                                    </div>
                                    <div class="ftr__address">
                                        <div class="ftr__address__icon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <div class="frt__address__details">
                                            <p>{{$Store->email}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Footer -->
                <!-- Start Single Footer -->
                <div class="col-md-6 col-lg-3 col-sm-12 sm--mt--40">
                    <div class="footer gallery">
                        <h2 class="ftr__title">Nossa galeria</h2>
                        <div class="footer__inner">
                            <ul class="sm__gallery__list">
                                <li><a ><img src="{{ url('site/images/gallery/sm-img/1.jpg') }}" alt="gallery images"></a></li>
                                <li><a ><img src="{{ url('site/images/gallery/sm-img/2.jpg') }}" alt="gallery images"></a></li>
                                <li><a ><img src="{{ url('site/images/gallery/sm-img/3.jpg') }}" alt="gallery images"></a></li>
                                <li><a ><img src="{{ url('site/images/gallery/sm-img/4.jpg') }}" alt="gallery images"></a></li>
                                <li><a ><img src="{{ url('site/images/gallery/sm-img/5.jpg') }}" alt="gallery images"></a></li>
                                <li><a ><img src="{{ url('site/images/gallery/sm-img/6.jpg') }}" alt="gallery images"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Footer -->
                <!-- Start Single Footer -->
                <div class="col-md-6 col-lg-3 col-sm-12 md--mt--40 sm--mt--40">
                    <div class="footer">
                        <h2 class="ftr__title">Atendimento</h2>
                        <div class="footer__inner">
                            @if(count($listStoreTimes) > 0)
                            <ul class="opening__time__list">
                                @foreach($listStoreTimes as $storeTime)
                                    @if($storeTime->periodo2_ini > 0)
                                        <li><span class="time__list__day2">{{$storeTime::find($storeTime->day)->pesqDayOfWeek->day}}</span><span class="time__list__time2">{{substr($storeTime->periodo1_ini, 0, 5)}} às {{substr($storeTime->periodo1_end, 0, 5)}} E {{substr($storeTime->periodo2_ini, 0, 5)}} às {{substr($storeTime->periodo2_end, 0, 5)}}</span>
                                    @else
                                        <li><span class="time__list__day">{{$storeTime::find($storeTime->day)->pesqDayOfWeek->day}}</span><span class="time__list__separator">.......</span><span class="time__list__time">{{substr($storeTime->periodo1_ini, 0, 5)}} às {{substr($storeTime->periodo1_end, 0, 5)}}</span></li>
                                    @endif
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Single Footer -->
                <!-- Start Single Footer -->
                <div class="col-md-6 col-lg-3 col-sm-12 md--mt--40 sm--mt--40">
                    <div class="footer">
                        <h2 class="ftr__title">Novidades</h2>
                        <div class="footer__inner">
                            <div class="lst__post__list">
                                @foreach($listLastProducts as $lastProduct)
                                    <div class="single__sm__post">
                                    <div class="sin__post__thumb">
                                        <a href="" class="view-product-info d-flex" data-object="product" data-prodid="{{$lastProduct->id}}">
                                            @if($lastProduct::find($lastProduct->id)->pesqFirstImageProduct)
                                                <img class="lst__post__list__img" src="{{ $pathImagens }}/products/store_id_{{$Store->id}}/{{ $lastProduct->id}}/small/{{ $lastProduct::find($lastProduct->id)->pesqFirstImageProduct->path_image }}" alt="blog images">
                                            @else
                                                <img class="lst__post__list__img" src="{{ $pathImagens }}/../../files/images/no_photo.png" alt="blog images">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="sin__post__details">
                                        <h6><a href="" class="view-product-info d-flex" data-object="product" data-prodid="{{$lastProduct->id}}">{{$lastProduct->name}}</a></h6>
                                        <p>{{ (strlen($lastProduct->description) > 25) ? substr($lastProduct->description,0,25).'...' : $lastProduct->description}}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Footer -->
            </div>
        </div>
    </div>
    <div class="copyright bg--theme">
        <div class="container">
            <div class="row">
                <div class="col col-lg-auto col-md-12 col-sm-12">
                    <div class="copyright__inner mt--10">
                        <div class="cpy__right--left">
                            <p>Todos os direitos reservados: <a target="_blank" href="https://www.iwpweb.com">IWP Web</a></p>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-auto col-md-12 col-sm-12">
                    <div class="copyright__inner mt--10">
                        <div class="cpy__right--left">
                            <p>Em parceria com: <a target="_blank" href="https://www.feevale.br">
                                    <img class="copyright__inner_img" src="{{ url('site/images/logo/feevale.png') }}" alt="logo images" width="220">
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cpy__right--left">
                    <ul class="social__icon">
                        <li><a target="_blank" title="Facebook" href="https://www.facebook.com/Ilpasticcinocaffe"><i class="fa fa-facebook"></i></a></li>
                        <li><a target="_blank" title="Instagram" href="https://www.instagram.com/ilpasticcinocaffe"><i class="fa fa-instagram"></i></a></li>
                        <li><a target="_blank" title="WhatsApp" href="https://api.whatsapp.com/send?l=pt_br&phone=55{{(($Store->fone_store_site) ? $Store->fone_store_site : $Store->fone1)}}"><i class="fa fa-whatsapp"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer Area -->
