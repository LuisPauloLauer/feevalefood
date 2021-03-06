<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\mdDemandsFood;
use App\mdStores;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class DemandsController extends Controller
{
    public function viewOrders($status = null)
    {
        if(is_null($status)){
            abort(404,"Sorry, You can do this actions");
        }

        switch ($status) {
            case 'included':
                $statusType = 'included';
                break;
            case 'confirmed':
                $statusType = 'confirmed';
                break;
            case 'togodelivery':
                $statusType = 'togodelivery';
                break;
            case 'delivered':
                $statusType = 'delivered';
                break;
            default:
                abort(404,"Sorry, You can do this actions");
        }

        $isUserOfStoreSelected = false;

        if( (Gate::allows('isadmintotal')) || (Gate::allows('isadminedit')) ) {

            $DemandsFood = DB::select('select
												tt.demand,
                                                tt.store,
                                                tt.user_site,
                                                tt.type_deliver,
                                                tt.type_payment,
                                                tt.sub_total_price,
                                                tt.tax_price,
                                                tt.shipping_price,
                                                tt.shipping_discount_price,
                                                tt.insurance_price,
                                                tt.handling_fee_price,
                                                tt.total_amount,
                                                tt.total_price,
                                                tt.id_item,
                                                @row_number := CASE WHEN @item_1 = tt.demand THEN
													@row_number + 1
												ELSE
													1
												END AS itens,
												@item_1:=tt.demand item_id_RN,
                                                tt.total_itens,
                                                tt.kit_id,
                                                tt.product_id,
                                                tt.kit_sub_itens,
                                                tt.amount,
                                                tt.observation
                                            from
                                                (select
                                                    d.id as demand,
                                                    d.store,
                                                    d.user_site,
                                                    d.type_deliver,
                                                    d.type_payment,
                                                    d.sub_total_price,
                                                    d.tax_price,
                                                    d.shipping_price,
                                                    d.shipping_discount_price,
                                                    d.insurance_price,
                                                    d.handling_fee_price,
                                                    d.total_amount,
                                                    d.total_price,
                                                    i.id as id_item,
                                                    (select count(demands_itens_food.id) from demands_itens_food
                                                                WHERE demands_itens_food.demand = d.id
                                                    ) as total_itens,
                                                    i.kit_id,
                                                    i.product_id,
                                                    i.kit_sub_itens,
                                                    i.amount,
                                                    i.observation
                                                FROM
                                                  demands_food as d,
                                                  demands_itens_food as i,
                                                  status_demands_food as s
                                                WHERE
                                                   d.id = i.demand
                                                   and s.id = d.status
                                                   and s.type = "'.$statusType.'"
                                                order by
                                                 d.id,
                                                 i.id	) as tt,
                                                 (SELECT @item_1:=0,@row_number:=0) as rn
                                             order by
												tt.demand,
                                                tt.id_item');

            switch ($status) {
                case 'included':
                    $returnView = 'admin.demands.ordersIncluded';
                    break;
                case 'confirmed':
                    $returnView = 'admin.demands.ordersConfirmed';
                    break;
                case 'togodelivery':
                    $returnView = 'admin.demands.ordersTogoDelivery';
                    break;
                case 'delivered':
                    $returnView = 'admin.demands.ordersDelivered';
                    break;
                default:
                    abort(404,"Sorry, You can do this actions");
            }

            return view($returnView, [
                'listDemandsFood' => $DemandsFood
            ]);

        } else {

            $UserAuth = Auth::user();

            foreach(Session::get('StoresUserAdm') as $store){
                if($store['selected']){
                    $storeUserAdmId = $store['id'];
                }
            }

            $relUsersAdmByStore = User::pesqUserAdmByStore($storeUserAdmId);

            foreach($relUsersAdmByStore as $userAdmByStore){
                if($userAdmByStore->useradm ==  $UserAuth->id){
                    $isUserOfStoreSelected = true;
                }
            }

            if($isUserOfStoreSelected) {

                $DemandsFood = DB::select('select
												tt.demand,
                                                tt.store,
                                                tt.user_site,
                                                tt.type_deliver,
                                                tt.type_payment,
                                                tt.sub_total_price,
                                                tt.tax_price,
                                                tt.shipping_price,
                                                tt.shipping_discount_price,
                                                tt.insurance_price,
                                                tt.handling_fee_price,
                                                tt.total_amount,
                                                tt.total_price,
                                                tt.id_item,
                                                @row_number := CASE WHEN @item_1 = tt.demand THEN
													@row_number + 1
												ELSE
													1
												END AS itens,
												@item_1:=tt.demand item_id_RN,
                                                tt.total_itens,
                                                tt.kit_id,
                                                tt.product_id,
                                                tt.kit_sub_itens,
                                                tt.amount,
                                                tt.observation
                                            from
                                                (select
                                                    d.id as demand,
                                                    d.store,
                                                    d.user_site,
                                                    d.type_deliver,
                                                    d.type_payment,
                                                    d.sub_total_price,
                                                    d.tax_price,
                                                    d.shipping_price,
                                                    d.shipping_discount_price,
                                                    d.insurance_price,
                                                    d.handling_fee_price,
                                                    d.total_amount,
                                                    d.total_price,
                                                    i.id as id_item,
                                                    (select count(demands_itens_food.id) from demands_itens_food
                                                                WHERE demands_itens_food.demand = d.id
                                                    ) as total_itens,
                                                    i.kit_id,
                                                    i.product_id,
                                                    i.kit_sub_itens,
                                                    i.amount,
                                                    i.observation
                                                FROM
                                                  demands_food as d,
                                                  demands_itens_food as i,
                                                  status_demands_food as s
                                                WHERE
                                                   d.id = i.demand
                                                   and s.id = d.status
                                                   and s.type = "'.$statusType.'"
                                                   and d.store = '.$storeUserAdmId.'
                                                order by
                                                 d.id,
                                                 i.id	) as tt,
                                                 (SELECT @item_1:=0,@row_number:=0) as rn
                                             order by
												tt.demand,
                                                tt.id_item');

                switch ($status) {
                    case 'included':
                        $returnView = 'admin.demands.ordersIncluded';
                        break;
                    case 'confirmed':
                        $returnView = 'admin.demands.ordersConfirmed';
                        break;
                    case 'togodelivery':
                        $returnView = 'admin.demands.ordersTogoDelivery';
                        break;
                    case 'delivered':
                        $returnView = 'admin.demands.ordersDelivered';
                        break;
                    default:
                        abort(404,"Sorry, You can do this actions");
                }

                return view($returnView, [
                    'listDemandsFood' => $DemandsFood
                ]);

            } else {
                abort(404,"Sorry, You can do this actions");
            }
        }
    }

    public function ordersChangeStatusType(Request $request)
    {
        $isUserOfStoreSelected = false;
        $demandID = $request->demand_id;
        $statusType = $request->status_type;

        if( mdDemandsFood::where('id', $demandID)->where('status', '<>', 5)->exists() ){

            $demand = mdDemandsFood::findOrFail($demandID);

            if( (Gate::allows('isadmintotal')) || (Gate::allows('isadminedit')) ) {

                $demand->status = $statusType;
                if($demand->save()){
                    $responseDemand['success'] = true;
                    switch ($statusType) {
                        case 2:
                            $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') atendido.';
                            break;
                        case 3:
                            $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') despachado.';
                            break;
                        case 4:
                            $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') Conclu??do.';
                            break;
                        case 5:
                            $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') Cancelado.';
                            break;
                    }
                    echo json_encode($responseDemand);
                    return;
                } else {
                    $responseDemand['success'] = false;
                    switch ($statusType) {
                        case 2:
                            $responseDemand['message'] = 'Erro ao atender o pedido c??digo: ('.$demandID.')!!!';
                            break;
                        case 3:
                            $responseDemand['message'] = 'Erro ao despachar o pedido c??digo: ('.$demandID.')!!!';
                            break;
                        case 4:
                            $responseDemand['message'] = 'Erro ao concluir o pedido c??digo: ('.$demandID.')!!!';
                            break;
                        case 5:
                            $responseDemand['message'] = 'Erro ao cancelar o pedido c??digo: ('.$demandID.')!!!';
                            break;
                    }
                    echo json_encode($responseDemand);
                    return;
                }

            } else {

                $UserAuth = Auth::user();

                foreach(Session::get('StoresUserAdm') as $store){
                    if($store['selected']){
                        $storeUserAdmId = $store['id'];
                    }
                }

                $relUsersAdmByStore = User::pesqUserAdmByStore($storeUserAdmId);

                foreach($relUsersAdmByStore as $userAdmByStore){
                    if($userAdmByStore->useradm ==  $UserAuth->id){
                        $isUserOfStoreSelected = true;
                    }
                }

                if($isUserOfStoreSelected){

                    if($demand->store == $storeUserAdmId ){

                        $demand->status = $statusType;
                        if($demand->save()){
                            $responseDemand['success'] = true;
                            switch ($statusType) {
                                case 2:
                                    $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') atendido.';
                                    break;
                                case 3:
                                    $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') despachado.';
                                    break;
                                case 4:
                                    $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') Conclu??do.';
                                    break;
                                case 5:
                                    $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') Cancelado.';
                                    break;
                            }
                            echo json_encode($responseDemand);
                            return;
                        } else {
                            $responseDemand['success'] = false;
                            switch ($statusType) {
                                case 2:
                                    $responseDemand['message'] = 'Erro ao atender o pedido c??digo: ('.$demandID.')!!!';
                                    break;
                                case 3:
                                    $responseDemand['message'] = 'Erro ao despachar o pedido c??digo: ('.$demandID.')!!!';
                                    break;
                                case 4:
                                    $responseDemand['message'] = 'Erro ao concluir o pedido c??digo: ('.$demandID.')!!!';
                                    break;
                                case 5:
                                    $responseDemand['message'] = 'Erro ao cancelar o pedido c??digo: ('.$demandID.')!!!';
                                    break;
                            }
                            echo json_encode($responseDemand);
                            return;
                        }

                    } else {
                        $responseDemand['success'] = false;
                        $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') n??o pertence a loja selecionada!!!';
                        echo json_encode($responseDemand);
                        return;
                    }

                } else {
                    abort(404,"Sorry, You can do this actions");
                }

            }

        } else {
            $responseDemand['success'] = false;
            $responseDemand['message'] = 'Pedido c??digo: ('.$demandID.') n??o existe!!!';
            echo json_encode($responseDemand);
            return;
        }

    }

    public function ordersToPrint(mdDemandsFood $demand)
    {
        $isUserOfStoreSelected = false;

        if( mdDemandsFood::where('id', $demand->id)->where('status', '<>', 5 )->exists() ){

            if( (Gate::allows('isadmintotal')) || (Gate::allows('isadminedit')) ) {

                $DemandsFood = DB::select('select
												tt.demand,
                                                tt.store,
                                                tt.user_site,
                                                tt.type_deliver,
                                                tt.type_payment,
                                                tt.sub_total_price,
                                                tt.tax_price,
                                                tt.shipping_price,
                                                tt.shipping_discount_price,
                                                tt.insurance_price,
                                                tt.handling_fee_price,
                                                tt.total_amount,
                                                tt.total_price,
                                                tt.id_item,
                                                @row_number := CASE WHEN @item_1 = tt.demand THEN
													@row_number + 1
												ELSE
													1
												END AS itens,
												@item_1:=tt.demand item_id_RN,
                                                tt.total_itens,
                                                tt.kit_id,
                                                tt.product_id,
                                                tt.kit_sub_itens,
                                                tt.amount,
                                                tt.observation
                                            from
                                                (select
                                                    d.id as demand,
                                                    d.store,
                                                    d.user_site,
                                                    d.type_deliver,
                                                    d.type_payment,
                                                    d.sub_total_price,
                                                    d.tax_price,
                                                    d.shipping_price,
                                                    d.shipping_discount_price,
                                                    d.insurance_price,
                                                    d.handling_fee_price,
                                                    d.total_amount,
                                                    d.total_price,
                                                    i.id as id_item,
                                                    (select count(demands_itens_food.id) from demands_itens_food
                                                                WHERE demands_itens_food.demand = d.id
                                                    ) as total_itens,
                                                    i.kit_id,
                                                    i.product_id,
                                                    i.kit_sub_itens,
                                                    i.amount,
                                                    i.observation
                                                FROM
                                                  demands_food as d,
                                                  demands_itens_food as i,
                                                  status_demands_food as s
                                                WHERE
                                                   d.id = i.demand
                                                   and s.id = d.status
                                                   and s.type <> "canceled"
                                                   and d.id = '.$demand->id.'
                                                order by
                                                 d.id,
                                                 i.id	) as tt,
                                                 (SELECT @item_1:=0,@row_number:=0) as rn
                                             order by
												tt.demand,
                                                tt.id_item');

                //return View::Make('admin.demands.ordersToPrint')->with('listDemandsFood', $DemandsFood);

                $fileName = 'pedidos.pdf';

                $mPDF = new Mpdf([
                    'margin_left'   => 10,
                    'margin_right'  => 10,
                    'margin_top'    => 15,
                    'margin_bottom' => 20,
                    'margin_header' => 10,
                    'margin_footer' => 10
                ]);

                $html = View::Make('admin.demands.ordersToPrint')->with('listDemandsFood', $DemandsFood);
                $html = $html->render();

                $mPDF->SetHeader('Loja: todas|Lista de Pedido|P??gina: {PAGENO}');
                $mPDF->SetFooter('Loja: todas');

                $styleSheet = file_get_contents(url('admin/node_modules/css/PDF_ordersToPrint.css'));
                $mPDF->WriteHTML($styleSheet,1);

                $mPDF->WriteHTML($html);
                $mPDF->Output($fileName, 'I');

            } else {

                $UserAuth = Auth::user();

                foreach(Session::get('StoresUserAdm') as $store){
                    if($store['selected']){
                        $storeUserAdmId = $store['id'];
                    }
                }

                $store = mdStores::where('id', $storeUserAdmId)->first();

                $relUsersAdmByStore = User::pesqUserAdmByStore($storeUserAdmId);

                foreach($relUsersAdmByStore as $userAdmByStore){
                    if($userAdmByStore->useradm ==  $UserAuth->id){
                        $isUserOfStoreSelected = true;
                    }
                }

                if($isUserOfStoreSelected){

                    if($demand->store == $storeUserAdmId ){

                        $DemandsFood = DB::select('select
												tt.demand,
                                                tt.store,
                                                tt.user_site,
                                                tt.type_deliver,
                                                tt.type_payment,
                                                tt.sub_total_price,
                                                tt.tax_price,
                                                tt.shipping_price,
                                                tt.shipping_discount_price,
                                                tt.insurance_price,
                                                tt.handling_fee_price,
                                                tt.total_amount,
                                                tt.total_price,
                                                tt.id_item,
                                                @row_number := CASE WHEN @item_1 = tt.demand THEN
													@row_number + 1
												ELSE
													1
												END AS itens,
												@item_1:=tt.demand item_id_RN,
                                                tt.total_itens,
                                                tt.kit_id,
                                                tt.product_id,
                                                tt.kit_sub_itens,
                                                tt.amount,
                                                tt.observation
                                            from
                                                (select
                                                    d.id as demand,
                                                    d.store,
                                                    d.user_site,
                                                    d.type_deliver,
                                                    d.type_payment,
                                                    d.sub_total_price,
                                                    d.tax_price,
                                                    d.shipping_price,
                                                    d.shipping_discount_price,
                                                    d.insurance_price,
                                                    d.handling_fee_price,
                                                    d.total_amount,
                                                    d.total_price,
                                                    i.id as id_item,
                                                    (select count(demands_itens_food.id) from demands_itens_food
                                                                WHERE demands_itens_food.demand = d.id
                                                    ) as total_itens,
                                                    i.kit_id,
                                                    i.product_id,
                                                    i.kit_sub_itens,
                                                    i.amount,
                                                    i.observation
                                                FROM
                                                  demands_food as d,
                                                  demands_itens_food as i,
                                                  status_demands_food as s
                                                WHERE
                                                   d.id = i.demand
                                                   and s.id = d.status
                                                   and s.type <> "canceled"
                                                   and d.id = '.$demand->id.'
                                                   and d.store = '.$storeUserAdmId.'
                                                order by
                                                 d.id,
                                                 i.id	) as tt,
                                                 (SELECT @item_1:=0,@row_number:=0) as rn
                                             order by
												tt.demand,
                                                tt.id_item');

                        //return View::Make('admin.demands.ordersToPrint')->with('listDemandsFood', $DemandsFood);

                        $fileName = 'pedidos.pdf';

                        $mPDF = new Mpdf([
                            'margin_left'   => 10,
                            'margin_right'  => 10,
                            'margin_top'    => 15,
                            'margin_bottom' => 20,
                            'margin_header' => 10,
                            'margin_footer' => 10
                        ]);

                        $html = View::Make('admin.demands.ordersToPrint')->with('listDemandsFood', $DemandsFood);
                        $html = $html->render();

                        $mPDF->SetHeader('Loja: '.$store->name.'|Lista de Pedido|P??gina: {PAGENO}');
                        $mPDF->SetFooter('Loja: '.$store->name);

                        $styleSheet = file_get_contents(url('admin/node_modules/css/PDF_ordersToPrint.css'));
                        $mPDF->WriteHTML($styleSheet,1);

                        $mPDF->WriteHTML($html);
                        $mPDF->Output($fileName, 'I');

                    } else {
                        abort(404,"Sorry, You can do this actions");
                    }

                } else {
                    abort(404,"Sorry, You can do this actions");
                }

            }

        } else {
            abort(404,"Sorry, You can do this actions");
        }

    }
}
