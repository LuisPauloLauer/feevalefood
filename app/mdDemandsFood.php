<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class mdDemandsFood extends Model
{
    protected $table = 'demands_food';

    public function getTotalAmountAttribute()
    {
        return round($this->attributes['total_amount'], 4);
    }

    public function addDemandOffShopCart($pIDUserSite, $pTypeDelivery, $pInformationPayment, $pKits = null, $pProducts = null, &$pmessageError)
    {
        $subTotalPrice = 0;
        $totalAmount = 0;

        $statusDemand = mdStatusDemandsFood::select('id')->where('type', 'included')->first();

        if($pKits){
            foreach($pKits as $Kit){
                $store = $Kit['item']['store'];
            }
        } else if ($pProducts) {
            foreach($pProducts as $Product){
                $store = $Product['item']['store'];
            }
        }

        $store = mdStores::where('id', $store)->first();
        $discountByEnterprise = UserSite::find($pIDUserSite)->pesqUniversityBuilding->percentage_discount;

        $this->attributes['status']                 = $statusDemand->id;
        $this->attributes['store']                  = $store->id;
        $this->attributes['user_site']              = $pIDUserSite;
        $this->attributes['type_deliver']           = $pTypeDelivery;
        $this->attributes['type_payment']           = $pInformationPayment['typePayment'];
        $this->attributes['invoice_number']         = $pInformationPayment['invoiceNumberPayment'];
        $this->attributes['currency_payment']       = $pInformationPayment['currencyPayment'];
        $this->attributes['money_change']           = $pInformationPayment['moneyChange'];

        if($pKits){
            foreach($pKits as $Kit){
                for($i=0; $i < count( $Kit['productSellSubItems'] ); $i++){
                    if($Kit['productSellSubItems'][$i][$Kit['item']['id']]['qnty'] > 0 ){

                        $ObjKit = mdKits::where('id', $Kit['item']['id'])->where('status', 'S')->first();

                        $subTotalPrice = $subTotalPrice + ($ObjKit->pesqPrice() * $Kit['productSellSubItems'][$i][$Kit['item']['id']]['qnty']);
                        $totalAmount = $totalAmount + $Kit['productSellSubItems'][$i][$Kit['item']['id']]['qnty'];
                    }
                }
            }
        }

        if($pProducts){
            foreach($pProducts as $Product){
                if($Product['qty'] > 0 ){

                    $ObjProduct = mdProducts::where('id', $Product['item']['id'])->where('status', 'S')->first();

                    $subTotalPrice = $subTotalPrice + ($ObjProduct->pesqPrice() * $Product['qty']);
                    $totalAmount = $totalAmount + $Product['qty'];
                }
            }
        }

        $this->attributes['total_amount']               = $totalAmount;
        $this->attributes['sub_total_price']            = $subTotalPrice;
        $this->attributes['tax_price']                  = floatval ($pInformationPayment['taxPricePayment']);
        $this->attributes['shipping_discount_price']    = 0;
        $this->attributes['insurance_price']            = floatval ($pInformationPayment['insurancePricePayment']);
        $this->attributes['handling_fee_price']         = floatval ($pInformationPayment['handlingFeePricePayment']);
        $this->attributes['percentage_discount']        = $discountByEnterprise;
        if(strtoupper($pInformationPayment['typePayment']) == 'PAYPAL'){
            $this->attributes['shipping_price']     = floatval ($pInformationPayment['shippingPricePayment']);
            if($discountByEnterprise > 0){
                $this->attributes['value_discount']     = floatval($pInformationPayment['shippingDiscountPricePayment']);
            }
            $this->attributes['total_price']        = floatval ($pInformationPayment['totalPayment']);
        } else {
            $this->attributes['shipping_price']     = $store->minimum_shipping;
            if($discountByEnterprise > 0){
                $this->attributes['value_discount']     = ($subTotalPrice + $store->minimum_shipping)/100*$discountByEnterprise;
                $this->attributes['value_discount']     = number_format($this->attributes['value_discount'],2);
                $this->attributes['total_price']        = ($subTotalPrice + $store->minimum_shipping) - $this->attributes['value_discount'];
                $this->attributes['total_price']        = number_format($this->attributes['total_price'],2);
            } else {
                $this->attributes['total_price']        = ($subTotalPrice + $store->minimum_shipping);
            }
        }

        try {
            if($this->save()){

                $saveItensStatus = $this->CreateDemandItensFood($this->attributes['id'], $pKits, $pProducts);

                $demandInfo = array(
                    "id_demand" => $this->attributes['id'],
                    "msg_erro_status" => $saveItensStatus,
                    "msg_erro_text" => null
                );

                return $demandInfo;

            } else {

                $demandInfo = array(
                    "id_demand" => 0,
                    "msg_erro_status" => false,
                    "msg_erro_text" => null
                );

                return $demandInfo;
            }
        } catch (\Exception $exception) {
            //throw new \ErrorException('Erro ao incluir o pedido!!! message: '.$exception->getMessage());
            $pmessageError = 'Erro ao incluir o pedido!!! message: '.$exception->getMessage();
            $demandInfo = array(
                "id_demand" => 0,
                "msg_erro_status" => false,
                "msg_erro_text" => $pmessageError
            );
            return $demandInfo;
        }
    }

    protected function CreateDemandItensFood($pDemand, $pKits, $pProducts)
    {
        $errorSaveItem = true;

        if($pKits){
            foreach($pKits as $Kit){
                for($i=0; $i < count( $Kit['productSellSubItems'] ); $i++){
                    if($Kit['productSellSubItems'][$i][$Kit['item']['id']]['qnty'] > 0 ){

                        $ObjKit = mdKits::where('id', $Kit['item']['id'])->where('status', 'S')->first();

                        $demandItens = new mdDemandsItensFood();

                        $demandItens->demand = $pDemand;
                        $demandItens->kit_id = $ObjKit->id;
                        $demandItens->amount = $Kit['productSellSubItems'][$i][$Kit['item']['id']]['qnty'];
                        $demandItens->observation = $Kit['productSellSubItems'][$i][$Kit['item']['id']]['observation'];

                        $kitSubItens = null;

                        for($j=0; $j < count( $Kit['productSellSubItems'][$i][$Kit['item']['id']]['productSellItems'] ); $j++){

                            $ObjProduct = mdProducts::where('id', $Kit['productSellSubItems'][$i][$Kit['item']['id']]['productSellItems'][$j])->where('status', 'S')->first();

                            if($j == (count( $Kit['productSellSubItems'][$i][$Kit['item']['id']]['productSellItems'] )-1) ){
                                $kitSubItens = $kitSubItens . $ObjProduct->id;
                            } else {
                                $kitSubItens = $kitSubItens . $ObjProduct->id . ',';
                            }

                        }

                        $demandItens->kit_sub_itens = $kitSubItens;

                        try {
                            if(!$demandItens->save()){
                                $errorSaveItem = false;
                            }
                        } catch (\Exception $exception) {
                            throw new \ErrorException('Erro ao incluir itens do pedido: ('.$pDemand.')');
                        }

                        unset($demandItens);

                    }
                }
            }
        }

        if($pProducts){
            foreach($pProducts as $Product){
                if($Product['qty'] > 0 ){

                    $ObjProduct = mdProducts::where('id', $Product['item']['id'])->where('status', 'S')->first();

                    $demandItens = new mdDemandsItensFood();

                    $demandItens->demand = $pDemand;
                    $demandItens->product_id = $ObjProduct->id;
                    $demandItens->amount = $Product['qty'];
                    $demandItens->observation = $Product['observation'];

                    $kitSubItens = null;

                    $demandItens->kit_sub_itens = $kitSubItens;

                    try {
                        if(!$demandItens->save()){
                            $errorSaveItem = false;
                        } else {
                            if(is_null($ObjProduct->sold)){
                                $ObjProduct->sold = $Product['qty'];
                            } else {
                                $ObjProduct->sold = $ObjProduct->sold + $Product['qty'];
                            }
                            $ObjProduct->save();
                        }
                    } catch (\Exception $exception) {
                        throw new \ErrorException('Erro ao incluir itens do pedido: ('.$pDemand.')');
                    }

                    unset($ObjProduct);
                    unset($demandItens);

                }
            }
        }

        return $errorSaveItem;

    }
}
