<?php

namespace App\Http\Controllers\site;

use App\CartKit;
use App\CartProduct;
use App\Http\Controllers\Controller;
use App\Library\GeneralLibrary;
use App\UserSite;
use App\mdSocialAccount;
use App\mdUniversitybuildings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class UsersSiteController extends Controller
{

    private $generalLibrary;

    public function __construct()
    {
        $this->generalLibrary = new GeneralLibrary();
    }

    function __destruct() {
        unset($this->generalLibrary);
    }

    public function loginWithEmail(Request $request)
    {
        $userSite = UserSite::where('id', $request->id)->first();
        $request->session()->put('userSiteLogged', $userSite);
        $response['success']        = true;
        if(Session::has('returnurlcallback')){
            $response['redirecturl']    = Session::get('returnurlcallback');
        } else {
            $response['redirecturl']    = url()->previous();
        }

        if(Session::has('shopCartKit')){
            $oldCartKit     = Session::get('shopCartKit');
            $objCartKit     = new CartKit($oldCartKit);
            $objCartKit->updateValues();
            $request->session()->put('shopCartKit', $objCartKit);
        }
        if(Session::has('shopCartProduct')){
            $oldCartProduct     = Session::get('shopCartProduct');
            $objCartProduct     = new CartProduct($oldCartProduct);
            $objCartProduct->updateValues();
            $request->session()->put('shopCartProduct', $objCartProduct);
        }

        echo json_encode($response);
        return;
    }

    public function loginUserSite(Request $request)
    {
        if(!Session::has('returnurlcallback')){
            $urlCallBack = url()->previous();
            $request->session()->put('returnurlcallback', $urlCallBack);
        }

        if(!Session::has('userSiteLogged')){
            $request->session()->put('showModalLoginUser', true);
            return redirect()->route('home.index');
        } else {
            if(Session::has('showModalLoginUser')){
                $request->session()->forget('showModalLoginUser');
            }

            if(Session::has('shopCartKit')){
                $oldCartKit     = Session::get('shopCartKit');
                $objCartKit     = new CartKit($oldCartKit);
                $objCartKit->updateValues();
                $request->session()->put('shopCartKit', $objCartKit);
            }
            if(Session::has('shopCartProduct')){
                $oldCartProduct     = Session::get('shopCartProduct');
                $objCartProduct     = new CartProduct($oldCartProduct);
                $objCartProduct->updateValues();
                $request->session()->put('shopCartProduct', $objCartProduct);
            }

            return redirect()->route('home.index');
        }
    }

    public function redirectToProviderFacebook(Request $request)
    {
        if(!Session::has('returnurlcallback')){
            $urlCallBack = url()->previous();
            $request->session()->put('returnurlcallback', $urlCallBack);
        }

        if(Session::has('userSiteLogged')){

            if(Session::has('shopCartKit')){
                $oldCartKit     = Session::get('shopCartKit');
                $objCartKit     = new CartKit($oldCartKit);
                $objCartKit->updateValues();
                $request->session()->put('shopCartKit', $objCartKit);
            }
            if(Session::has('shopCartProduct')){
                $oldCartProduct     = Session::get('shopCartProduct');
                $objCartProduct     = new CartProduct($oldCartProduct);
                $objCartProduct->updateValues();
                $request->session()->put('shopCartProduct', $objCartProduct);
            }

            return redirect($request->session()->get('returnurlcallback'));
        }

        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToProviderGoogle(Request $request)
    {
        if(!Session::has('returnurlcallback')){
            $urlCallBack = url()->previous();
            $request->session()->put('returnurlcallback', $urlCallBack);
        }

        if(Session::has('userSiteLogged')){

            if(Session::has('shopCartKit')){
                $oldCartKit     = Session::get('shopCartKit');
                $objCartKit     = new CartKit($oldCartKit);
                $objCartKit->updateValues();
                $request->session()->put('shopCartKit', $objCartKit);
            }
            if(Session::has('shopCartProduct')){
                $oldCartProduct     = Session::get('shopCartProduct');
                $objCartProduct     = new CartProduct($oldCartProduct);
                $objCartProduct->updateValues();
                $request->session()->put('shopCartProduct', $objCartProduct);
            }

            return redirect($request->session()->get('returnurlcallback'));
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackFacebook(Request $request)
    {
        $request->session()->forget('userSiteLogged');

        $userSiteFacebook = Socialite::driver('facebook')->user();

        $SocialAccount = mdSocialAccount::where('provider_name', 'facebook')
            ->where('email', $userSiteFacebook->getEmail())
            ->first();

        if ($SocialAccount) {

            $userSite  = mdSocialAccount::find($SocialAccount->id)->pesqUserSite;

            $request->session()->put('userSiteLogged', $userSite);

            if(Session::has('shopCartKit')){
                $oldCartKit     = Session::get('shopCartKit');
                $objCartKit     = new CartKit($oldCartKit);
                $objCartKit->updateValues();
                $request->session()->put('shopCartKit', $objCartKit);
            }
            if(Session::has('shopCartProduct')){
                $oldCartProduct     = Session::get('shopCartProduct');
                $objCartProduct     = new CartProduct($oldCartProduct);
                $objCartProduct->updateValues();
                $request->session()->put('shopCartProduct', $objCartProduct);
            }

            //return redirect('/');
            //return redirect()->route('home.index');
            return redirect($request->session()->get('returnurlcallback'));

        } else {

            $userSite = null;

            if ($emailUserSiteFacebook = $userSiteFacebook->getEmail()) {
                $userSite = UserSite::where('email', $emailUserSiteFacebook)->first();
            }

            if (!$userSite) {

               $userSiteData = [
                    'status'                => 'S',
                    'name'                  => $userSiteFacebook->getName(),
                    'email'                 => $userSiteFacebook->getEmail(),
                    'email_verified_at'     => now(),
                    'avatar'                => $userSiteFacebook->getAvatar(),
                    'token'                 => $userSiteFacebook->token,
                    'provider'              => 'facebook',
                    'provider_id'           => $userSiteFacebook->getId(),
                    'show_modal_adduser'    => true
                ];

               $request->session()->put('userSiteData', $userSiteData);
               return redirect()->route('usersite.create');
               //return redirect()->route('home.index');
               //return view('site.siteHome',[
               //    'userSiteData'   =>  $userSiteData
               //]);
            }

            if($userSite){

                $userSite->allSocialAccountsByUserSite()->create([
                    'provider_name'     => 'facebook',
                    'provider_id'       => $userSiteFacebook->getId(),
                    'email'             => $userSite->email,
                ]);

                $request->session()->put('userSiteLogged', $userSite);

                if(Session::has('shopCartKit')){
                    $oldCartKit     = Session::get('shopCartKit');
                    $objCartKit     = new CartKit($oldCartKit);
                    $objCartKit->updateValues();
                    $request->session()->put('shopCartKit', $objCartKit);
                }
                if(Session::has('shopCartProduct')){
                    $oldCartProduct     = Session::get('shopCartProduct');
                    $objCartProduct     = new CartProduct($oldCartProduct);
                    $objCartProduct->updateValues();
                    $request->session()->put('shopCartProduct', $objCartProduct);
                }

                //return redirect()->route('home.index');
                return redirect($request->session()->get('returnurlcallback'));

            }
        }
    }

    public function handleProviderCallbackGoogle(Request $request)
    {
        $request->session()->forget('userSiteLogged');

        $userSiteGoogle = Socialite::driver('google')->user();

        $SocialAccount = mdSocialAccount::where('provider_name', 'google')
            ->where('email', $userSiteGoogle->getEmail())
            ->first();

        if ($SocialAccount) {

            $userSite  = mdSocialAccount::find($SocialAccount->id)->pesqUserSite;

            $request->session()->put('userSiteLogged', $userSite);

            if(Session::has('shopCartKit')){
                $oldCartKit     = Session::get('shopCartKit');
                $objCartKit     = new CartKit($oldCartKit);
                $objCartKit->updateValues();
                $request->session()->put('shopCartKit', $objCartKit);
            }
            if(Session::has('shopCartProduct')){
                $oldCartProduct     = Session::get('shopCartProduct');
                $objCartProduct     = new CartProduct($oldCartProduct);
                $objCartProduct->updateValues();
                $request->session()->put('shopCartProduct', $objCartProduct);
            }

            // return redirect()->route('home.index');
            return redirect($request->session()->get('returnurlcallback'));

        } else {

            $userSite = null;

            if ($emailUserSiteGoogle = $userSiteGoogle->getEmail()) {
                $userSite = UserSite::where('email', $emailUserSiteGoogle)->first();
            }

            if (!$userSite) {

                $userSiteData = [
                    'status'                => 'S',
                    'name'                  => $userSiteGoogle->getName(),
                    'email'                 => $userSiteGoogle->getEmail(),
                    'email_verified_at'     => now(),
                    'avatar'                => $userSiteGoogle->getAvatar(),
                    'token'                 => $userSiteGoogle->token,
                    'provider'              => 'google',
                    'provider_id'           => $userSiteGoogle->getId(),
                    'show_modal_adduser'    => true
                ];

                $request->session()->put('userSiteData', $userSiteData);
                return redirect()->route('usersite.create');
                //return redirect()->route('home.index');
            }

            if($userSite){

                $userSite->allSocialAccountsByUserSite()->create([
                    'provider_name'     => 'google',
                    'provider_id'       => $userSiteGoogle->getId(),
                    'email'             => $userSite->email,
                ]);

                $request->session()->put('userSiteLogged', $userSite);

                if(Session::has('shopCartKit')){
                    $oldCartKit     = Session::get('shopCartKit');
                    $objCartKit     = new CartKit($oldCartKit);
                    $objCartKit->updateValues();
                    $request->session()->put('shopCartKit', $objCartKit);
                }
                if(Session::has('shopCartProduct')){
                    $oldCartProduct     = Session::get('shopCartProduct');
                    $objCartProduct     = new CartProduct($oldCartProduct);
                    $objCartProduct->updateValues();
                    $request->session()->put('shopCartProduct', $objCartProduct);
                }

                //return redirect()->route('home.index');
                return redirect($request->session()->get('returnurlcallback'));

            }
        }
    }

    public function createUserSite(Request $request)
    {
        $universityBuildings = mdUniversitybuildings::where('id', '<>', 1)->where('company_name', '<>', 'AREZZO')->get();

        $request->session()->put('universityBuildings', $universityBuildings);

        return redirect($request->session()->get('returnurlcallback'));
    }

    public function storeUserSite(Request $request)
    {
        $userSiteData = $request->session()->get('userSiteData');
        $name = $request->name;
        $fone = $request->fone;
        $building = $request->building;
        $agreeTerms = $request->terms;

        if(is_null($userSiteData['email'])){
            $userSiteData['email'] = $request->email;
        }

        if(!filter_var($userSiteData['email'], FILTER_VALIDATE_EMAIL)){
            $login['success'] = false;
            $login['message'] = 'O e-mail informado n??o ?? valido!';
            echo json_encode($login);
            return;
        }

        if(is_null($name)){
            $login['success'] = false;
            $login['message'] = 'Informe o seu nome!';
            echo json_encode($login);
            return;
        }

        if(is_null($fone)){
            $login['success'] = false;
            $login['message'] = 'Informe o seu telefone';
            echo json_encode($login);
            return;
        } else {
            if(UserSite::where('fone', preg_replace('/\D+/', '', $fone))->exists()) {
                $login['success'] = false;
                $login['message'] = 'Usu??rio j?? cadastrado com esse n??mero de telefone!';
                echo json_encode($login);
                return;
            }
            if(!$this->generalLibrary->validatePhoneNumber($fone)){
                $login['success'] = false;
                $login['message'] = 'N??mero de telefone inv??lido!';
                echo json_encode($login);
                return;
            }
        }

        $fone = $this->generalLibrary->adjustDigitNumberNine($fone);

        if(is_null($building)){
            $login['success'] = false;
            $login['message'] = 'Voc?? deve selecionar uma empresa!';
            echo json_encode($login);
            return;
        } else {
            $ConsultBuilding = mdUniversitybuildings::where('id', $building)->exists();
            if(!$ConsultBuilding){
                $login['success'] = false;
                $login['message'] = 'Empresa n??o existe!';
                echo json_encode($login);
                return;
            }
        }

        if(is_null($agreeTerms)){
            $login['success'] = false;
            $login['message'] = 'Voc?? deve aceitar os termos!';
            echo json_encode($login);
            return;
        }

        $UserSite = new UserSite();

        if($userSiteData){
            $UserSite->status               = $userSiteData['status'];
            $UserSite->is_verified          = 1;
            $UserSite->universitybuilding   = $building;
            $UserSite->name                 = $name;
            $UserSite->fone                 = $fone;
            $UserSite->email                = $userSiteData['email'];
            $UserSite->email_verified_at    = $userSiteData['email_verified_at'];
            $UserSite->remember_token       = $userSiteData['token']; //Str::random(10);
        }

        try {

            if($UserSite->save()){

                $request->session()->put('userSiteLogged', $UserSite);

                if(Session::has('shopCartKit')){
                    $oldCartKit     = Session::get('shopCartKit');
                    $objCartKit     = new CartKit($oldCartKit);
                    $objCartKit->updateValues();
                    $request->session()->put('shopCartKit', $objCartKit);
                }
                if(Session::has('shopCartProduct')){
                    $oldCartProduct     = Session::get('shopCartProduct');
                    $objCartProduct     = new CartProduct($oldCartProduct);
                    $objCartProduct->updateValues();
                    $request->session()->put('shopCartProduct', $objCartProduct);
                }

                $UserSite->allSocialAccountsByUserSite()->create([
                    'provider_name' => $userSiteData['provider'],
                    'provider_id'   => $userSiteData['provider_id'],
                    'email'         => $userSiteData['email'],
                ]);

                $login['success'] = true;
                echo json_encode($login);
                return;

            } else {
                $login['success'] = false;
                $login['message'] = 'Erro ao cadastrar o usu??rio';
                echo json_encode($login);
                return;
            }

        } catch (\Exception $exception) {
            $login['success'] = false;
            $login['message'] = 'Erro ao cadastrar o usu??rio';
            echo json_encode($login);
            return;
        }
    }

    public function logoutUserSite(Request $request)
    {
        $request->session()->forget('userSiteLogged');
        $request->session()->forget('shopCartKit');
        $request->session()->forget('shopCartProduct');

        return redirect()->route('home.index');
    }

    public function userPolicy()
    {
        return view('site.user.policy');
    }

    public function userTerms()
    {
        return view('site.user.terms');
    }

}
