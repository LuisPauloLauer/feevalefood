<?php

namespace App\Http\Controllers\site;

use App\CartKit;
use App\CartProduct;
use App\Http\Controllers\Controller;
use App\mdDemandsFood;
use App\mdStores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserSiteDemandController extends Controller
{
    private $idOfStore = null;

    public function __construct()
    {
        $this->idOfStore = env('APP_STORE_ID');
    }

    public function createDemand(Request $request)
    {
        $messageError                   = null;
        $userSite                       = null;
        $typeDelivery                   = 'Entregar';
        $invoiceNumberPayment           = 'sem-numero';
        $typePayment                    = $request->type_payment;
        $currencyPayment                = 'BRL';
        $taxPricePayment                = 0;
        $shippingPricePayment           = 0;
        $shippingDiscountPricePayment   = 0;
        $insurancePricePayment          = 0;
        $handlingFeePricePayment        = 0;
        $totalPayment                   = 0;

        if(isset($request->money_change)){
            $moneyChange                    = $request->money_change;
        } else {
            $moneyChange                    = 0;
        }

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
            "moneyChange"                   => $moneyChange
        );

        $DemandFood = new mdDemandsFood();

        if( (Session::has('shopCartKit')) && (Session::has('shopCartProduct')) ){

            $oldCartKit = Session::get('shopCartKit');
            $cartKit = new CartKit($oldCartKit);
            $oldCartProduct = Session::get('shopCartProduct');
            $cartProduct = new CartProduct($oldCartProduct);

            $Kits = $cartKit->items;
            $Products = $cartProduct->items;

            $userSite = Session::get('userSiteLogged')->id;

            $DemandFoodStatus = $DemandFood->addDemandOffShopCart($userSite, $typeDelivery, $informationPayment, $Kits, $Products, $messageError);

            if($DemandFoodStatus['msg_erro_status']){

                $request->session()->forget('shopCartKit');
                $request->session()->forget('shopCartProduct');

                $responseDemand['success'] = $DemandFoodStatus['msg_erro_status'];
                $responseDemand['message'] = 'Pedido Nº: '.$DemandFoodStatus['id_demand'].' inserido com sucesso.';
                $responseDemand['id_demand'] = $DemandFoodStatus['id_demand'];
                echo json_encode($responseDemand);
                return;
            }

        } else if (Session::has('shopCartKit')){

            $oldCartKit = Session::get('shopCartKit');
            $cartKit = new CartKit($oldCartKit);

            $Kits = $cartKit->items;
            $Products = null;

            $userSite = Session::get('userSiteLogged')->id;

            $DemandFoodStatus = $DemandFood->addDemandOffShopCart($userSite, $typeDelivery, $informationPayment, $Kits, $Products, $messageError);

            if($DemandFoodStatus['msg_erro_status']){

                $request->session()->forget('shopCartKit');
                $request->session()->forget('shopCartProduct');

                $responseDemand['success'] = $DemandFoodStatus['msg_erro_status'];
                $responseDemand['message'] = 'Pedido Nº: '.$DemandFoodStatus['id_demand'].' inserido com sucesso.';
                $responseDemand['id_demand'] = $DemandFoodStatus['id_demand'];
                echo json_encode($responseDemand);
                return;
            }

        } else if (Session::has('shopCartProduct')){

            $oldCartProduct = Session::get('shopCartProduct');
            $cartProduct = new CartProduct($oldCartProduct);

            $Kits = null;
            $Products = $cartProduct->items;

            $userSite = Session::get('userSiteLogged');

            $DemandFoodStatus = $DemandFood->addDemandOffShopCart($userSite->id, $typeDelivery, $informationPayment, $Kits, $Products, $messageError);

            if($DemandFoodStatus['msg_erro_status']){

                $request->session()->forget('shopCartKit');
                $request->session()->forget('shopCartProduct');

                $responseDemand['success'] = $DemandFoodStatus['msg_erro_status'];
                $responseDemand['message'] = 'Pedido Nº: '.$DemandFoodStatus['id_demand'].' inserido com sucesso.';
                $responseDemand['idDemand'] = $DemandFoodStatus['id_demand'];
                echo json_encode($responseDemand);
                return;
            }

        } else {
            $responseDemand['success'] = false;
            $responseDemand['message'] = 'Erro ao fazer o pedido!!!';
            echo json_encode($responseDemand);
        }
    }

    public function viewAllDemandsByUser(Request $request)
    {

        if(Session::has('userSiteLogged')){
            $userSite = $request->session()->get('userSiteLogged');
        } else {
            return back();
        }

        $demandByUser = DB::table('demands_food as ped')
                        ->select(   'ped.id as demand',
                                            'ped.status as status',
                                            'st.name as status_name',
                                            'ped.store',
                                            'ped.user_site',
                                            'ped.type_deliver',
                                            'ped.type_payment',
                                            'ped.total_amount',
                                            'ped.sub_total_price',
                                            'ped.shipping_price',
                                            'ped.percentage_discount',
                                            'ped.value_discount',
                                            'ped.total_price',
                                            'ped.created_at',
                                            DB::raw('date_format(ped.created_at, "%d/%m/%Y") as created_at_date'),
                                            DB::raw('date_format(ped.created_at, "%H:%i") as created_at_hour'),
                                            'ped.money_change'
                        )
            ->join('userssite as use', 'use.id', '=', 'ped.user_site')
            ->join('status_demands_food as st', 'st.id', '=', 'ped.status')
            ->where('store', $this->idOfStore)
            ->where('user_site', $userSite->id)
            ->orderBy('ped.id', 'desc')
            ->get();

        $demandItensByUser = DB::table('demands_itens_food as ite')
            ->select(   'ite.id as item',
                                'ite.demand',
                                'ite.kit_id',
                                'ite.product_id',
                                'ite.observation',
                                'ite.kit_sub_itens',
                                'kit.name as kit_name',
                                'prod.name as product_name',
                                DB::raw('ROUND(ite.amount) as amount'),
                                DB::raw('CASE WHEN kit.unit_promotion_price > 0 THEN kit.unit_promotion_price
                                                    ELSE kit.unit_price
                                                END AS kit_price'),
                                DB::raw('CASE WHEN prod.unit_promotion_price > 0 THEN prod.unit_promotion_price
                                                    ELSE prod.unit_price
                                                END AS product_price')
            )
            ->join('demands_food as ped', 'ped.id', '=', 'ite.demand')
            ->join('userssite as use', 'use.id', '=', 'ped.user_site')
            ->leftJoin('kits as kit', 'kit.id', '=', 'ite.kit_id')
            ->leftJoin('products as prod', 'prod.id', '=', 'ite.product_id')
            ->where('ped.store', $this->idOfStore)
            ->where('ped.user_site', $userSite->id)
            ->orderBy('ite.demand', 'desc')
            ->orderBy('ite.id', 'asc')
            ->get();

        $demandByUser = json_encode($demandByUser);
        $demandItensByUser = json_encode($demandItensByUser);
        $Store = mdStores::where('id', $this->idOfStore)->first();
        $Store = json_encode($Store);

        return view('site.user.demands', [
            'Store'             => $Store,
            'listDemand'        => $demandByUser,
            'listDemandItens'   => $demandItensByUser
        ]);
    }
}
