<?php

namespace App\Http\Controllers\site;

use App\Cart;
use App\CartKit;
use App\CartProduct;
use App\Http\Controllers\Controller;
use App\Library\FilesControl;
use App\mdCategoriesProduct;
use App\mdDemandsFood;
use App\mdImagensKits;
use App\mdImagensProducts;
use App\mdKits;
use App\mdProducts;
use App\mdRelKitsProducts;
use App\mdStoresPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class shopCartController extends Controller
{
    private $idOfStore = null;

    public function __construct()
    {
        $this->idOfStore = env('APP_STORE_ID');
    }

    public function showModalProduct(Request $request)
    {
        $object = $request->product_object;
        $id = $request->product_id;
        $emptyCart = $request->empty_cart;
        $categoryId = null;
        $numArrayCategory = 0;

        if($object == 'kit'){

            if( mdKits::where('id', $id)->where('status', 'S')->exists() ){

                $Kit = mdKits::findOrFail($id);

                if($Kit->store <> $this->idOfStore){

                    $responseProduct['success']     = false;
                    $responseProduct['message']     = 'Kit não pertence a esta loja!!!';
                    $responseProduct['object']      = null;
                    $responseProduct['id']          = null;
                    echo json_encode($responseProduct);
                    return;
                }

                if($emptyCart){
                    $request->session()->forget('shopCartKit');
                    $request->session()->forget('shopCartProduct');
                }

                if (Session::has('shopCartKit')){

                    $oldCartKitStore = Session::get('shopCartKit');
                    $cartKitStore = new CartKit($oldCartKitStore);
                    $cartKitStoreItems = $cartKitStore->items;

                    foreach ($cartKitStoreItems as $kitItem){
                        if($kitItem['item']['store'] <> $Kit->store){

                            $responseProduct['success']     = false;
                            $responseProduct['message']     = 'diffstore';
                            $responseProduct['object']      = null;
                            $responseProduct['id']          = null;
                            echo json_encode($responseProduct);
                            return;
                        }
                    }
                }

                if (Session::has('shopCartProduct')){

                    $oldCartProductStore = Session::get('shopCartProduct');
                    $cartProductStore = new CartKit($oldCartProductStore);
                    $cartProductStoreItems = $cartProductStore->items;

                    foreach ($cartProductStoreItems as $productItem){
                        if($productItem['item']['store'] <> $Kit->store){

                            $responseProduct['success']     = false;
                            $responseProduct['message']     = 'diffstore';
                            $responseProduct['object']      = null;
                            $responseProduct['id']          = null;
                            echo json_encode($responseProduct);
                            return;
                        }
                    }
                }

                $relProductsKit = mdRelKitsProducts::where('kit', $Kit->id)->get();

                if( (count($relProductsKit) <= 0) ){

                    $responseProduct['success']     = false;
                    $responseProduct['message']     = 'Kit não existe!!!';
                    $responseProduct['object']      = null;
                    $responseProduct['id']          = null;
                    echo json_encode($responseProduct);
                    return;
                }

                for ($i = 0; $i < count($relProductsKit); $i++){
                    $inProductsKit[$i] = $relProductsKit[$i]->product;
                }

                $ProductsKit = mdProducts::where('status', 'S')->whereIn('id', $inProductsKit)->orderBy('category_product', 'asc')->get();

                $relImagensKit  = mdImagensKits::where('kit', $Kit->id)->orderby('id', 'asc')->get();

                $responseProduct['success']                 = true;
                $responseProduct['object']                  = 'kit';
                $responseProduct['id']                      = $Kit->id;
                $responseProduct['nameproduct']             = $Kit->name;
                $responseProduct['description']             = $Kit->description;
                $responseProduct['unit_price']              = $Kit->unit_price;
                $responseProduct['unit_promotion_price']    = $Kit->unit_promotion_price;
                $responseProduct['imagens']                 = $relImagensKit;
                $responseProduct['products']                = $ProductsKit;

                foreach ($ProductsKit as $Product){
                    if($categoryId <> $Product->category_product){
                        $products_category[$numArrayCategory] = array(
                            "products_category_id" => $Product->category_product,
                            "products_category_name" => mdCategoriesProduct::find($Product->category_product)->name,
                        );

                        $numArrayCategory++;
                    }

                    $categoryId = $Product->category_product;
                }

                $responseProduct['products_category']       = $products_category;

                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success']     = false;
                $responseProduct['message']     = 'Kit não existe!!!';
                $responseProduct['object']      = null;
                $responseProduct['id']          = null;
                echo json_encode($responseProduct);
                return;
            }
        }

        if($object == 'product'){

            if( mdProducts::where('id', $id)->where('status', 'S')->exists() ){

                $Product = mdProducts::findOrFail($id);

                if($Product->store <> $this->idOfStore){

                    $responseProduct['success']     = false;
                    $responseProduct['message']     = 'Produto não pertence a esta loja!!!';
                    $responseProduct['object']      = null;
                    $responseProduct['id']          = null;
                    echo json_encode($responseProduct);
                    return;
                }

                if (Session::has('shopCartProduct')){
                    $oldCartProductStore = Session::get('shopCartProduct');
                    $cartProductStore = new CartKit($oldCartProductStore);
                    $cartProductStoreItems = $cartProductStore->items;

                    foreach ($cartProductStoreItems as $productItem){
                        if($productItem['item']['store'] <> $Product->store){

                            $responseProduct['success']     = false;
                            $responseProduct['message']     = 'diffstore';
                            $responseProduct['object']      = null;
                            $responseProduct['id']          = null;
                            echo json_encode($responseProduct);
                            return;
                        }
                    }
                }

                if (Session::has('shopCartKit')){
                    $oldCartKitStore = Session::get('shopCartKit');
                    $cartKitStore = new CartKit($oldCartKitStore);
                    $cartKitStoreItems = $cartKitStore->items;

                    foreach ($cartKitStoreItems as $kitItem){
                        if($kitItem['item']['store'] <> $Product->store){

                            $responseProduct['success']     = false;
                            $responseProduct['message']     = 'diffstore';
                            $responseProduct['object']      = null;
                            $responseProduct['id']          = null;
                            echo json_encode($responseProduct);
                            return;
                        }
                    }
                }

                $relImagensProduct  = mdImagensProducts::where('product', $Product->id)->orderby('id', 'asc')->get();

                $responseProduct['success']                 = true;
                $responseProduct['object']                  = 'product';
                $responseProduct['id']                      = $Product->id;
                $responseProduct['nameproduct']             = $Product->name;
                $responseProduct['description']             = $Product->description;
                $responseProduct['unit_price']              = $Product->unit_price;
                $responseProduct['unit_promotion_price']    = $Product->unit_promotion_price;
                $responseProduct['imagens']                 = $relImagensProduct;

                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success']     = false;
                $responseProduct['message']     = 'Produto não existe!!!';
                $responseProduct['object']      = null;
                $responseProduct['id']          = null;
                echo json_encode($responseProduct);
                return;
            }
        }
    }

    public function addToCart(Request $request)
    {

        $object = $request->product_object;
        $id = $request->product_id;
        $productQnty = $request->product_qnty;
        $productObservation = $request->product_observation;

        if($object == 'kit'){
            $productsSell = $request->products_sell;
            $Kit = mdKits::findOrFail($id);

            if($Kit){

                $oldCart = Session::has('shopCartKit') ? Session::get('shopCartKit') : null;
                $cartKit = new CartKit($oldCart);
                $cartKit->add($Kit, $Kit->id, $productQnty, $productObservation, $productsSell);

                $request->session()->put('shopCartKit', $cartKit);

                $responseProduct['success'] = true;
                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success'] = false;
                $responseProduct['message'] = 'error';
                echo json_encode($responseProduct);
                return;

            }
        }

        if($object == 'product'){
            $Product = mdProducts::findOrFail($id);

            if($Product){
                $oldCart = Session::has('shopCartProduct') ? Session::get('shopCartProduct') : null;
                $cartProduct = new CartProduct($oldCart);
                $cartProduct->add($Product, $Product->id, $productQnty, $productObservation);

                $request->session()->put('shopCartProduct', $cartProduct);

                $responseProduct['success'] = true;
                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success'] = false;
                $responseProduct['message'] = 'error';
                echo json_encode($responseProduct);
                return;

            }
        }

    }

    public function getCart()
    {

        $pathImagens = FilesControl::getPathImages();

        if( (Session::has('shopCartKit')) && (Session::has('shopCartProduct')) ){

            $oldCartKit = Session::get('shopCartKit');
            $cartKit = new CartKit($oldCartKit);
            $oldCartProduct = Session::get('shopCartProduct');
            $cartProduct = new CartProduct($oldCartProduct);

        //    dd($cartKit,$cartProduct);

            return view('site.shopcart.cart',[
                'Kits'                      =>  $cartKit->items,
                'KitsTotalQnty'             =>  $cartKit->totalQty,
                'KitsTotalPrice'            =>  $cartKit->totalPrice,
                'Products'                  =>  $cartProduct->items,
                'ProductsTotalQnty'         =>  $cartProduct->totalQty,
                'ProductsTotalPrice'        =>  $cartProduct->totalPrice,
                'pathImagens'               =>  $pathImagens
            ]);

        } else if (Session::has('shopCartKit')){

            $oldCartKit = Session::get('shopCartKit');
            $cartKit = new CartKit($oldCartKit);

        //    dd($cartKit);

            return view('site.shopcart.cart',[
                'Kits'                      =>  $cartKit->items,
                'KitsTotalQnty'             =>  $cartKit->totalQty,
                'KitsTotalPrice'            =>  $cartKit->totalPrice,
                'pathImagens'               =>  $pathImagens
            ]);

        } else if (Session::has('shopCartProduct')){

            $oldCartProduct = Session::get('shopCartProduct');
            $cartProduct = new CartProduct($oldCartProduct);

       //     dd($cartProduct);

            return view('site.shopcart.cart',[
                'Products'                  =>  $cartProduct->items,
                'ProductsTotalQnty'         =>  $cartProduct->totalQty,
                'ProductsTotalPrice'        =>  $cartProduct->totalPrice,
                'pathImagens'               =>  $pathImagens
            ]);

        } else {
            die('sem carrinho');
        }

    }

    public function editQntyItemToCart(Request $request)
    {
        $object = $request->product_object;
        $id = $request->product_id;
        if(isset($request->product_sub_items)){
            $sellItemsIndex = $request->product_sub_items;
        }
        $operator = $request->product_operator;

        if($object == 'kit'){
            $Kit = mdKits::findOrFail($id);

            if($Kit){

                $oldCart = Session::has('shopCartKit') ? Session::get('shopCartKit') : null;
                $cartKit = new CartKit($oldCart);
                $cartKit->edit($Kit->id, $sellItemsIndex, $operator);

                $request->session()->put('shopCartKit', $cartKit);

                $responseProduct['success'] = true;
                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success'] = false;
                echo json_encode($responseProduct);
                return;

            }
        }

        if($object == 'product'){
            $Product = mdProducts::findOrFail($id);

            if($Product){
                $oldCart = Session::has('shopCartProduct') ? Session::get('shopCartProduct') : null;

                if($operator == 'minus'){
                    if($oldCart->items[$Product->id]['qty'] == 1){
                        $responseProduct['success'] = false;
                        echo json_encode($responseProduct);
                        return;
                    }
                }

                $cartProduct = new CartProduct($oldCart);
                $cartProduct->edit($Product->id, $operator);

                $request->session()->put('shopCartProduct', $cartProduct);

                $responseProduct['success'] = true;
                $responseProduct['cartProduct'] = $cartProduct;
                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success'] = false;
                echo json_encode($responseProduct);
                return;

            }
        }
    }

    public function deleteItemToCart(Request $request)
    {
        $object = $request->product_object;
        $id = $request->product_id;
        if(isset($request->product_sub_items)){
            $sellItemsIndex = $request->product_sub_items;
        }

        if($object == 'kit'){
            $Kit = mdKits::findOrFail($id);

            if($Kit){

                $oldCart = Session::has('shopCartKit') ? Session::get('shopCartKit') : null;
                $cartKit = new CartKit($oldCart);
                $cartKit->dell($Kit->id, $sellItemsIndex);

                if($cartKit->totalQty > 0){
                    $request->session()->put('shopCartKit', $cartKit);
                }else{
                    $request->session()->forget('shopCartKit');
                }


                $responseProduct['success'] = true;
                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success'] = false;
                echo json_encode($responseProduct);
                return;

            }
        }

        if($object == 'product'){
            $Product = mdProducts::findOrFail($id);

            if($Product){
                $oldCart = Session::has('shopCartProduct') ? Session::get('shopCartProduct') : null;
                $cartProduct = new CartProduct($oldCart);
                $cartProduct->dell($Product->id);

                if(empty($cartProduct->items)){
                    $request->session()->forget('shopCartProduct');
                    $cartProduct = 0;
                } else {
                    $request->session()->put('shopCartProduct', $cartProduct);
                }

                $responseProduct['success'] = true;
                $responseProduct['cartProduct'] = $cartProduct;
                echo json_encode($responseProduct);
                return;

            } else {

                $responseProduct['success'] = false;
                echo json_encode($responseProduct);
                return;

            }
        }
    }

    public function emptyCart(Request $request)
    {
        $request->session()->forget('shopCartKit');
        $request->session()->forget('shopCartProduct');

        return back();
    }

    public function checkOutCart(Request $request)
    {
        if(!Session::has('shopCartKit') && !Session::has('shopCartProduct')){
            return redirect()->route('home.index');
        } else if(!Session::has('userSiteLogged')){
            $urlCallBack = url()->current();
            $request->session()->put('returnurlcallback', $urlCallBack);
            return redirect()->route('usersite.login');
        } else if (Session::has('shopCartKit') || Session::has('shopCartProduct')){
            $request->session()->forget('returnurlcallback');
            $request->session()->forget('showModalLoginUser');
            $storePayment = mdStoresPayment::where('status', 'S')->where('store', Session::get('shopCartProduct')->store)->where('type_payment_local', 'loja')->orderBy('id', 'asc')->get();
            return view('site.checkout.checkout',[
                'listStorePayment'               => $storePayment,
            ]);
        }
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
                echo json_encode($responseDemand);
                return;
            }

        } else {
            $responseDemand['success'] = false;
            $responseDemand['message'] = 'Erro ao fazer o pedido!!!';
            echo json_encode($responseDemand);
        }
    }

}
