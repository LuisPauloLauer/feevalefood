<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Library\GeneralLibrary;
use App\mdDemandsFood;
use App\mdDemandsItensFood;
use App\mdKits;
use App\mdProducts;
use App\mdStores;
use App\mdUniversitybuildings;
use App\UserSite;
use Illuminate\Http\JsonResponse;
use Twilio\Rest\Client;

class notificationController extends Controller
{
    private $generalLibrary;

    public function __construct()
    {
        $this->generalLibrary = new GeneralLibrary();
    }

    function __destruct() {
        unset($this->generalLibrary);
    }

    public function sendMessageWhatsApp(mdDemandsFood $demand)
    {
        if($demand) {

            $store = mdStores::where('id', $demand->store)->first();

            $user = UserSite::where('id', $demand->user_site)->first();

            $building = mdUniversitybuildings::where('id', $user->universitybuilding)->first();

            if($store->fone_store_site){
                $foneStore = $store->fone_store_site;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone_store_site, false, true);
            } else {
                $foneStore = $store->fone1;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone1, false, true);
            }

            $msgBody =  'Pedido novo incluído!'."\n".
                //'Pedidosssssssss novo incluído!'."\n".
                'Pedido código: '.$demand->id."\n".
                'Empresa: '.$building->company_name."\n".
                'Prédio: '.$building->building_name."\n".
                'Cliente: '.$user->name."\n".
                'Fone: '.$user->fone."\n\n".
                'Acesse o pedido em:'."\n".'https://www.pt-lietoo.com';

            $sid = env('TWILIO_CLIENT_ID');
            $token = env('TWILIO_CLIENT_TOKEN');
            $twilio = new Client($sid, $token);

            /*$message = $twilio->messages
                ->create($foneTo, // to
                    [
                        "from" => "whatsapp:+555191098868",
                        "body" => $msgBody
                    ]
                );

            return $message;*/

            try {

                $message = $twilio->messages
                    ->create($foneTo, // to
                        [
                            "from" => "whatsapp:+555191098868",
                            "body" => $msgBody
                        ]
                    );

                $response['success'] = true;
                $response['message'] = 'Notificacao enviada com sucesso';
                echo json_encode($response);
                return;

            } catch (\Exception $exception) {
                $response['success'] = false;
                $response['message'] =  'Erro ao enviar mensagem de aviso do pedido ('.$demand->id.') para o whatsApp '.
                                        'Contate com a loja pelo numero: '.$foneStore;
                $response['messagelink'] = 'https://api.whatsapp.com/send?l=pt_br&phone=55'.$foneStore.'&text=Olá%20gostaria%20de%20avisar%20sobre%20a%20inclusão%20do%20pedido:%20'.$demand->id.'%20empresa:%20'.$building->company_name;
                $response['phone']      = $foneStore;
                echo json_encode($response);
                return;
            }

        } else {
            $response['success'] = false;
            $response['message'] = 'Pedido não existe!';
            echo json_encode($response);
            return;
        }

    }

    public function sendMessageWhatsAppDemand(mdDemandsFood $demand)
    {
        if($demand) {

            $store = mdStores::where('id', $demand->store)->first();

            $user = UserSite::where('id', $demand->user_site)->first();

            $building = mdUniversitybuildings::where('id', $user->universitybuilding)->first();

            if($store->fone_store_site){
                $foneStore = $store->fone_store_site;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone_store_site, false, true);
            } else {
                $foneStore = $store->fone1;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone1, false, true);
            }

            $msgBody =  'Pedido novo incluído!'."\n".
                //'Pedidosssssssss novo incluído!'."\n".
                'Pedido código: '.$demand->id."\n".
                'Empresa: '.$building->company_name."\n".
                'Prédio: '.$building->building_name."\n".
                'Cliente: '.$user->name."\n".
                'Fone: '.$user->fone."\n\n".
                'Acesse o pedido em:'."\n".'https://www.pt-lietoo.com';

            $sid = env('TWILIO_CLIENT_ID');
            $token = env('TWILIO_CLIENT_TOKEN');
            $twilio = new Client($sid, $token);

            /*$message = $twilio->messages
                ->create($foneTo, // to
                    [
                        "from" => "whatsapp:+555191098868",
                        "body" => $msgBody
                    ]
                );

            return $message;*/

            try {

                $message = $twilio->messages
                    ->create($foneTo, // to
                        [
                            "from" => "whatsapp:+555191098868",
                            "body" => $msgBody
                        ]
                    );

                return redirect()->route('demands.view');

            } catch (\Exception $exception) {
                return redirect()->route('demands.view');
            }

        } else {
            return redirect()->route('demands.view');
        }

    }
}
