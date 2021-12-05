<!-- Login Form -->
<div class="accountbox-wrapper">
    <div class="accountbox text-left">
        <div class="accountbox__inner tab-content" id="myTabContent">
            <div class="text-center">
                <h5>Falta pouco para matar sua fome!</h5>
                <h5>Como deseja continuar?</h5>
            </div>
            <ul class="nav accountbox__filters" id="myTab" role="tablist">
                <li>
                    <a class="active" id="log-tab" data-toggle="tab" href="#log" role="tab" aria-controls="log" aria-selected="true">Login</a>
                </li>
                <li>
                    <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" class="">Cadastro</a>
                </li>
            </ul>
            <div class="accountbox__inner tab-content" id="myTabContent">
                <div class="accountbox__login tab-pane fade active show" id="log" role="tabpanel" aria-labelledby="log-tab">
                    <div class="accountbox__login__email">
                        <div id="form-login-user">
                            <div-form-log-user :store="{{$Store}}"></div-form-log-user>
                        </div>
                    </div>
                    <div class="accountbox__login__mdsocial">
                        <div class="accountbox-login__others text-center">
                            <h6>Ou Login com</h6>
                            <a href="{{ route('usersite.login.facebook') }}" class="btn btn-block btn-primary">
                                <i class="fa fa-facebook mr-2"></i>
                                Login com Facebook
                            </a>
                            <a href="{{ route('usersite.login.google') }}" class="btn btn-block btn-danger">
                                <i class="fa fa-google-plus mr-2"></i>
                                Login com Google
                            </a>
                        </div>
                    </div>
                </div>
                <div class="accountbox__register tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div id="form-register-user">
                        <div-form-reg-user :store="{{$Store}}"></div-form-reg-user>
                    </div>
                </div>
                <span class="accountbox-close-button text-danger"><i class="fa fa-close"></i></span>
            </div>
        </div>
    </div>
</div>
<!-- //Login Form -->
<!-- AddUser Form -->
<div class="adduser-wrapper">
    <div class="accountbox text-left">
        @if( Session::has('userSiteData') )
            <div class="accountbox__register">
                <div class="text-center">
                    <h5>Olá {{Session::get('userSiteData')['name']}}</h5>
                    <h5>Termine o seu cadastro:</h5>
                </div>
                <div class="accountbox__register__final">
                    <form class="form-signin" name="formUserSiteCad">
                        @csrf
                        <div class="alert alert-danger alert-dismissible d-none addUserMessageBox text-white" role="alert"></div>
                        <div class="input-group mb-3">
                            <input id="idnameAddUser" name="name" value="{{Session::get('userSiteData')['name']}}" type="text" class="form-control" placeholder="Seu nome">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fa fa-user"></span>
                                </div>
                            </div>
                        </div>
                        @if(is_null(Session::get('userSiteData')['email']))
                            <div class="input-group mb-3">
                                <input id="idemailAddUser" name="email" value="" type="email" class="form-control" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fa fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="input-group mb-3">
                            <input id="idphoneAddUser" name="fone" type="text" class="form-control phone-mask" placeholder="Ex.: (51) 98888-8888" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fa fa-phone"></span>
                                </div>
                            </div>
                        </div>
                        @if( Session::has('universityBuildings') )
                            <h5>Selecione uma empresa:</h5>
                            <div class="input-group mb-3">
                                <select name="building" size="5" data-placeholder="selecione uma empresa..." class="custom-select chosen-select">
                                    <option value=""></option>
                                    @foreach(Session::get('universityBuildings') as $building)
                                        <option value="{{ $building->id }}">{{ $building->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                    <label for="agreeTerms">
                                        I agree to the <a target="_blank" href="https://www.ilpasticcinocaffe.com/">terms</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="single-input">
                            <button type="submit" class="food__btn"><span>Cadastrar</span></button>
                        </div>
                    </form>
                </div>
                <span class="accountbox-close-button text-danger"><i class="fa fa-close"></i></span>
            </div>
        @endif
    </div>
</div>
<!-- //AddUser Form -->
