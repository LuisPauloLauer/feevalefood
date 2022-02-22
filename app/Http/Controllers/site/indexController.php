<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Library\FilesControl;
use App\Library\GeneralLibrary;
use App\mdDaysOfWeek;
use App\mdDeliveryStoreTimes;
use App\mdSegments;
use App\mdStores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class indexController extends Controller
{
    private $generalLibrary;
    private $idOfStore = null;
    private $isStoreOpen = false;

    public function __construct()
    {
        $this->idOfStore = env('APP_STORE_ID');
        $this->generalLibrary = new GeneralLibrary();
    }

    function __destruct() {
        unset($this->generalLibrary);
    }

    public function index()
    {
        $pathImagens = FilesControl::getPathImages();

        $this->isStoreOpen = $this->generalLibrary->isStoreOpenToDelivery();

        $Store = mdStores::where('id', $this->idOfStore)->first();

        $storeTimes = mdDeliveryStoreTimes::where('store', $Store->id)->where('status', 'S')->orderBy('day', 'asc')->get();

        $CategoriesProducts = mdStores::find($Store->id)->pesqCategoriesProductByStore('S', true)->get();

        $Kits = mdStores::find($Store->id)->pesqKitsByStore('S', null, true)->get();

        $Products = mdStores::find($Store->id)->pesqProductsByStore('S', null, true)->get();

        $moreSaletKits = mdStores::find($Store->id)->pesqKitsByStore('S', null, true, 'sold', 'desc')->limit(6)->get();

        $moreSaleProducts = mdStores::find($Store->id)->pesqProductsByStore('S', null, true, 'sold', 'desc')->limit(6)->get();

        $lastProducts = mdStores::find($Store->id)->pesqProductsByStore('S', null, true, 'id', 'desc')->limit(3)->get();

        return view('site.siteHome',[
            'pathImagens'               => $pathImagens,
            'isStoreOpen'               => $this->isStoreOpen,
            'Store'                     => $Store,
            'listStoreTimes'            => $storeTimes,
            'listCategoriesProducts'    => $CategoriesProducts,
            'listKit'                   => $Kits,
            'listProduct'               => $Products,
            'listMoreSaleKit'           => $moreSaletKits,
            'listMoreSaleProduct'       => $moreSaleProducts,
            'listLastProducts'          => $lastProducts
        ]);
    }
}
