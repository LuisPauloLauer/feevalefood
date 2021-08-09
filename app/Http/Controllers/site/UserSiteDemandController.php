<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\mdDemandsFood;
use App\UserSite;
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
        $appUrl = json_encode(env('APP_URL'));

        return view('site.user.demands', [
            'appUrl'            => $appUrl,
            'listDemand'        => $demandByUser,
            'listDemandItens'   => $demandItensByUser
        ]);
    }
}
