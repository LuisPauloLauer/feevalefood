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
use Illuminate\Http\Request;
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
        if(mdDemandsFood::where('id', $demand->id)->exists()) {

            $store = mdStores::where('id', $demand->store)->first();

            $user = UserSite::where('id', $demand->user_site)->first();

            $building = mdUniversitybuildings::where('id', $user->universitybuilding)->first();

            $itens = mdDemandsItensFood::where('demand', $demand->id)->orderBy('demand', 'asc')->orderBy('id', 'asc')->get();

            if($store->fone_store_site){
                $foneStore = $store->fone_store_site;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone_store_site, false, true);
            } else {
                $foneStore = $store->fone1;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone1, false, true);
            }

            $msgBody =  '*Pedido novo incluído!*'."\n".
                '*Pedido código:* '.$demand->id."\n".
                '*Empresa:* '.$building->company_name."\n".
                '*Prédio:* '.$building->building_name."\n".
                '*Cliente:* '.$user->name."\n".
                '*Fone:* '.$user->fone."\n";

            foreach ($itens as $item){
                if(!is_null($item->kit_id)){
                    $msgBody = $msgBody."\n".'*Item:* '.mdKits::find($item->kit_id)->name.
                        ' *Código:* '.((!is_null(mdKits::find($item->kit_id)->codigo_pdv_store)) ? mdKits::find($item->kit_id)->codigo_pdv_store : 'sem código').
                        ' *Qtd.:* '.$item->amount;
                } else {
                    $msgBody = $msgBody."\n".'*Item:* '.mdProducts::find($item->product_id)->name.
                        ' *Código:* '.((!is_null(mdProducts::find($item->product_id)->codigo_pdv_store)) ? mdProducts::find($item->product_id)->codigo_pdv_store : 'sem código').
                        ' *Qtd.:* '.$item->amount;
                }
            }

            $msgBody = $msgBody."\n\n".
                '*Tp entrega:* '.$demand->type_deliver."\n".
                '*Tp pagamento:* '.$demand->type_payment."\n".
                '*Vlr total:* R$'.number_format($demand->total_price,2, ',', '.').' *Qtd total:* '.round($demand->total_amount, 4).
                (($demand->type_payment == 'Dinheiro') ? "\n".'*Troco:* R$' .number_format($demand->money_change,2, ',', '.') : '')."\n\n";

            if(env('APP_ENV') == 'local'){
                $msgBody = $msgBody.'Acesse o pedido em:'."\n".'localhost/delivery_d/public/dashboard/orders/included';
            } else {
                $msgBody = $msgBody.'Acesse o pedido em:'."\n".env('APP_URL_DASHBOARD').'/dashboard/orders/included';
            }

            $sid = env('TWILIO_CLIENT_ID');
            $token = env('TWILIO_CLIENT_TOKEN');
            $twilio = new Client($sid, $token);

            try {

                $message = $twilio->messages
                    ->create($foneTo, // to
                        [
                            "from" => "whatsapp:+14155238886",
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
        if(mdDemandsFood::where('id', $demand->id)->exists()) {

            $store = mdStores::where('id', $demand->store)->first();

            $user = UserSite::where('id', $demand->user_site)->first();

            $building = mdUniversitybuildings::where('id', $user->universitybuilding)->first();

            $itens = mdDemandsItensFood::where('demand', $demand->id)->orderBy('demand', 'asc')->orderBy('id', 'asc')->get();

            if($store->fone_store_site){
                $foneStore = $store->fone_store_site;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone_store_site, false, true);
            } else {
                $foneStore = $store->fone1;
                $foneTo = "whatsapp:+55".$this->generalLibrary->adjustDigitNumberNine($store->fone1, false, true);
            }

            $msgBody =  '*Pedido novo incluído!*'."\n".
                '*Pedido código:* '.$demand->id."\n".
                '*Empresa:* '.$building->company_name."\n".
                '*Prédio:* '.$building->building_name."\n".
                '*Cliente:* '.$user->name."\n".
                '*Fone:* '.$user->fone."\n";

            foreach ($itens as $item){
                if(!is_null($item->kit_id)){
                    $msgBody = $msgBody."\n".'*Item:* '.mdKits::find($item->kit_id)->name.
                        ' *Código:* '.((!is_null(mdKits::find($item->kit_id)->codigo_pdv_store)) ? mdKits::find($item->kit_id)->codigo_pdv_store : 'sem código').
                        ' *Qtd.:* '.$item->amount;
                } else {
                    $msgBody = $msgBody."\n".'*Item:* '.mdProducts::find($item->product_id)->name.
                        ' *Código:* '.((!is_null(mdProducts::find($item->product_id)->codigo_pdv_store)) ? mdProducts::find($item->product_id)->codigo_pdv_store : 'sem código').
                        ' *Qtd.:* '.$item->amount;
                }
            }

            $msgBody = $msgBody."\n\n".
                '*Tp entrega:* '.$demand->type_deliver."\n".
                '*Tp pagamento:* '.$demand->type_payment."\n".
                '*Vlr total:* R$'.number_format($demand->total_price,2, ',', '.').' *Qtd total:* '.round($demand->total_amount, 4).
                (($demand->type_payment == 'Dinheiro') ? "\n".'*Troco:* R$' .number_format($demand->money_change,2, ',', '.') : '')."\n\n";

            if(env('APP_ENV') == 'local'){
                $msgBody = $msgBody.'Acesse o pedido em:'."\n".'localhost/delivery_d/public/dashboard/orders/included';
            } else {
                $msgBody = $msgBody.'Acesse o pedido em:'."\n".env('APP_URL_DASHBOARD').'/dashboard/orders/included';
            }

            $sid = env('TWILIO_CLIENT_ID');
            $token = env('TWILIO_CLIENT_TOKEN');
            $twilio = new Client($sid, $token);

            try {

                $message = $twilio->messages
                    ->create($foneTo, // to
                        [
                            "from" => "whatsapp:+14155238886",
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
