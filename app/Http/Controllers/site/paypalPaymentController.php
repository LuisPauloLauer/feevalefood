<?php

namespace App\Http\Controllers\site;

use App\CartKit;
use App\CartProduct;
use App\Http\Controllers\Controller;
use App\mdDemandsFood;
use App\Paypal\CreatePayment;
use App\Paypal\ExecutePayment;
use App\UserSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class paypalPaymentController extends Controller
{
    //Sessions vars and Class vars
    private $userSite               = null;
    private $kits                   = null;
    private $products               = null;
    // Errors vars
    private $messageError           = null;
    // Delivery vars
    private $deliveryType           = null;
    private $deliveryTypePayment    = null;
    private $discountByEnterprise   = 0;

    public function create(Request $request)
    {
        if(Session::has('userSiteLogged')){
            $this->userSite = Session::get('userSiteLogged');
            $this->discountByEnterprise = UserSite::find($this->userSite->id)->pesqUniversityBuilding->percentage_discount;
        }
        if(Session::has('shopCartKit')){
            $oldCartKit     = Session::get('shopCartKit');
            $objCartKit     = new CartKit($oldCartKit);
            $this->kits     = $objCartKit->items;
        }
        if(Session::has('shopCartProduct')){
            $oldCartProduct     = Session::get('shopCartProduct');
            $objCartProduct     = new CartProduct($oldCartProduct);
            $this->products     = $objCartProduct->items;
        }

        if(isset($request->delivery_type)){
            $this->deliveryType = $request->delivery_type;
        } else {
            $this->deliveryType = 'Entregar';
        }

        if(isset($request->delivery_type_payment)){
            $this->deliveryTypePayment = $request->delivery_type_payment;
        } else {
            $this->deliveryTypePayment = 'paypal';
        }

        $infoPayment = [
            'deliveryTypePayment' => $this->deliveryTypePayment,
            'deliveryDiscount'    => $this->discountByEnterprise
        ];

        $objCreatePayment = new CreatePayment($infoPayment);

        if(($this->kits && $this->userSite) || ($this->products && $this->userSite)){
            $paymentCreate = $objCreatePayment->create($this->kits, $this->products, $this->messageError);
            if($paymentCreate){
                return $paymentCreate;
            } else {
                $responsePaymentPaypal['success'] = false;
                $responsePaymentPaypal['message'] = $this->messageError;
                echo json_encode($responsePaymentPaypal);
                return;
            }
        } else {
            return back();
        }
    }

    public function payPalStatus(Request $request)
    {
        if(isset($request->delivery_type)){
            $this->deliveryType = $request->delivery_type;
        } else {
            $this->deliveryType = 'Entregar';
        }

        if(Session::has('userSiteLogged')){
            $this->userSite = Session::get('userSiteLogged');
        }
        if(Session::has('shopCartKit')){
            $oldCartKit     = Session::get('shopCartKit');
            $objCartKit     = new CartKit($oldCartKit);
            $this->kits     = $objCartKit->items;
        }
        if(Session::has('shopCartProduct')){
            $oldCartProduct     = Session::get('shopCartProduct');
            $objCartProduct     = new CartProduct($oldCartProduct);
            $this->products     = $objCartProduct->items;
        }

        $typePayment                    = null;
        $invoiceNumberPayment           = null;
        $currencyPayment                = null;
        $taxPricePayment                = 0;
        $shippingPricePayment           = 0;
        $shippingDiscountPricePayment   = 0;
        $insurancePricePayment          = 0;
        $handlingFeePricePayment        = 0;
        $totalPayment                   = 0;

        if(($this->kits && $this->userSite) || ($this->products && $this->userSite)){
            $objExecutePayment = new ExecutePayment();

            $PaymentExecute = $objExecutePayment->execute($messageError);

            if ($PaymentExecute == false) {
                //return $messageError;
                $responsePaymentPaypal['success'] = false;
                $responsePaymentPaypal['message'] = $messageError;
                echo json_encode($responsePaymentPaypal);
                return;
            } else {
                if ($PaymentExecute->getState() === 'approved') {

                    $jsonPaymentExecute = json_decode($PaymentExecute);

                    $typePayment = $jsonPaymentExecute->payer->payment_method;
                    //$typePayment = 'paypal';

                    $jsonTransactions = $jsonPaymentExecute->transactions;

                    foreach ($jsonTransactions as $dataTransaction) {
                        if (property_exists($dataTransaction, "invoice_number")) {
                            $invoiceNumberPayment = $dataTransaction->invoice_number;
                        }

                        if (property_exists($dataTransaction, "amount")) {
                            $jsonTransactionsAmount = $dataTransaction->amount;
                        }
                    }

                    $totalPayment                   = $jsonTransactionsAmount->total;
                    $currencyPayment                = $jsonTransactionsAmount->currency;
                    $jsonTransactionsDetails        = $jsonTransactionsAmount->details;
                    $taxPricePayment                = $jsonTransactionsDetails->tax;
                    $shippingPricePayment           = $jsonTransactionsDetails->shipping;
                    $shippingDiscountPricePayment   = $jsonTransactionsDetails->shipping_discount;
                    $insurancePricePayment          = $jsonTransactionsDetails->insurance;
                    $handlingFeePricePayment        = $jsonTransactionsDetails->handling_fee;

                    $informationPayment = array(
                        "invoiceNumberPayment"          => $invoiceNumberPayment,
                        "typePayment"                   => $typePayment,
                        "currencyPayment"               => $currencyPayment,
                        "taxPricePayment"               => $taxPricePayment,
                        "shippingPricePayment"          => $shippingPricePayment,
                        "shippingDiscountPricePayment"  => $shippingDiscountPricePayment,
                        "insurancePricePayment"         => $insurancePricePayment,
                        "handlingFeePricePayment"       => $handlingFeePricePayment,
                        "totalPayment"                  => $totalPayment,
                        "moneyChange"                   => 0
                    );

                    $DemandFood = new mdDemandsFood();
                    $DemandFoodStatus = $DemandFood->addDemandOffShopCart($this->userSite->id, $this->deliveryType, $informationPayment, $this->kits, $this->products, $this->messageError);
                    if ($DemandFoodStatus['msg_erro_status']) {

                        $request->session()->forget('shopCartKit');
                        $request->session()->forget('shopCartProduct');

                        /*
                        $responseDemand['success'] = $DemandFoodStatus['msg_erro_status'];
                        $responseDemand['message'] = 'Pedido Nº: '.$DemandFoodStatus['id_demand'].' inserido com sucesso.';
                        $responseDemand['id_demand'] = $DemandFoodStatus['id_demand'];
                        echo json_encode($responseDemand);
                        return; */

                        return redirect()->route('message.whatsapp.demand', ['demand' => $DemandFoodStatus['id_demand']]);
                        //return redirect()->route('demands.view');

                    } else {
                        $responseDemand['success'] = false;
                        if(!is_null($DemandFoodStatus['msg_erro_text'])){
                            $responseDemand['message'] = $DemandFoodStatus['msg_erro_text'];
                        } else {
                            $responseDemand['message'] = 'Erro ao fazer o pedido. Contate o suporte!!! Pagamento de Número: ' . $invoiceNumberPayment;
                        }
                        echo json_encode($responseDemand);
                        return;
                    }

                } else {
                    $responseDemand['success'] = false;
                    $responseDemand['message'] = 'Erro ao efetuar o pagamento. Pagamento não aprovado!!!';
                    echo json_encode($responseDemand);
                    return;
                }
            }
        } else {
            $responseDemand['success'] = false;
            $responseDemand['message'] = 'Erro ao fazer o pedido. Verifique seu loguin e carrinho!!!';
            echo json_encode($responseDemand);
            return;
        }
    }
}
