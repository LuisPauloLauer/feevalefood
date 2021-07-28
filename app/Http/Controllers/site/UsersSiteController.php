<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\UserSite;
use App\mdSocialAccount;
use App\mdUniversitybuildings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class UsersSiteController extends Controller
{
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
            return redirect($request->session()->get('returnurlcallback'));
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackFacebook(Request $request)
    {
        $request->session()->forget('userSiteLogged');

        $userSiteFacebook = Socialite::driver('facebook')->user();

        $SocialAccount = mdSocialAccount::where('provider_name', 'facebook')
            ->where('provider_id', $userSiteFacebook->getId())
            ->first();

        if ($SocialAccount) {

            $userSite  = mdSocialAccount::find($SocialAccount->id)->pesqUserSite;

            $request->session()->put('userSiteLogged', $userSite);

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
                    'slug'                  => Str::slug($userSiteFacebook->getName()),
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
            ->where('provider_id', $userSiteGoogle->getId())
            ->first();

        if ($SocialAccount) {

            $userSite  = mdSocialAccount::find($SocialAccount->id)->pesqUserSite;

            $request->session()->put('userSiteLogged', $userSite);

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
                    'slug'                  => Str::slug($userSiteGoogle->getName()),
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

                //return redirect()->route('home.index');
                return redirect($request->session()->get('returnurlcallback'));

            }
        }
    }

    public function createUserSite(Request $request)
    {
        $universityBuildings = mdUniversitybuildings::where('id', '<>', 1)->get();

        $request->session()->put('universityBuildings', $universityBuildings);

        return redirect($request->session()->get('returnurlcallback'));
    }

    public function storeUserSite(Request $request)
    {
        //Faz adicao do nono digito
        function numeroAjuste($numero)
        {
            //Se numero tem 11 digitos nao faz nada
            if (strlen($numero) == 11)
                return $numero;

            //se numero tem 10 digitos verifica
            if (strlen($numero) == 10) {

                //Pega ddd e numero
                $ddd = substr($numero, 0, 2);
                $num = str_replace($ddd, '', $numero);

                //Verifica se é celular, se nao for retorno o proprio numero
                if ($num[0] == 2 || $num[0] == 3) {
                    return $numero;
                }

                //se for celular, so tem 8 numeros, adiciona o 9
                if (strlen($num) == 8) {
                    $num = "9{$num}";
                }

                return "{$ddd}{$num}";
            }
        }

        //Limpa o numero removendo caracteres
        function numeroSanitize($numero)
        {
            return preg_replace('/[^0-9]/', '', $numero);
        }

        function numeroNonoDigito($numero)
        {
            if (empty($numero))
                return '';

            $numero_ = numeroSanitize($numero);
            $numero_ = numeroAjuste($numero_);

            return $numero_;
        }

        function validatePhoneNumber($phoneNumber)
        {
            $phoneNumber = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $phoneNumber))))));

            //$regexTelefone = "^[0-9]{11}$";

            // $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
            $regexPhone = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/'; // Regex para validar somente celular
            if (preg_match($regexPhone, $phoneNumber)) {
                return true;
            } else {
                return false;
            }
        }

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
            $login['message'] = 'O e-mail informado não é valido!';
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
                $login['message'] = 'Usuário já cadastrado com esse número de telefone!';
                echo json_encode($login);
                return;
            }
            if(!validatePhoneNumber($fone)){
                $login['success'] = false;
                $login['message'] = 'Número de telefone inválido!';
                echo json_encode($login);
                return;
            }
        }

        $fone = numeroNonoDigito($fone);

        if(is_null($building)){
            $login['success'] = false;
            $login['message'] = 'Você deve selecionar uma empresa!';
            echo json_encode($login);
            return;
        } else {
            $ConsultBuilding = mdUniversitybuildings::where('id', $building)->exists();
            if(!$ConsultBuilding){
                $login['success'] = false;
                $login['message'] = 'Empresa não existe!';
                echo json_encode($login);
                return;
            }
        }

        if(is_null($agreeTerms)){
            $login['success'] = false;
            $login['message'] = 'Você deve aceitar os termos!';
            echo json_encode($login);
            return;
        }

        $UserSite = new UserSite();

        if($userSiteData){
            $UserSite->status               = $userSiteData['status'];
            $UserSite->universitybuilding   = $building;
            $UserSite->name                 = $name;
            $UserSite->slug                 = $name;
            $UserSite->fone                 = $fone;
            $UserSite->email                = $userSiteData['email'];
            $UserSite->email_verified_at    = $userSiteData['email_verified_at'];
            $UserSite->remember_token       = $userSiteData['token']; //Str::random(10);
        }

        try {

            if($UserSite->save()){

                $request->session()->put('userSiteLogged', $UserSite);

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
                $login['message'] = 'Erro ao cadastrar o usuário';
                echo json_encode($login);
                return;
            }

        } catch (\Exception $exception) {
            $login['success'] = false;
            $login['message'] = 'Erro ao cadastrar o usuário';
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
}
