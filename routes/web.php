<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*++++++++++++++++++++++++++++++++++++++++++++++++   SITE    ++++++++++++++++++++++++++++++++++++++++++++++++*/

////----------  Home ------------////
Route::get('/', 'site\indexController@index')->name('home.index');

Route::post('/product','site\shopCartController@showModalProduct')->name('product.showmodal');

////----------  Shop Cart ------------////
//Route::get('/carrinho','site\shopCartController@getCart')->name('cart.view');
//Route::get('/carrinho/limpar','site\shopCartController@emptyCart')->name('cart.empty');
Route::post('/carrinho/adicionar-item','site\shopCartController@addToCart')->name('cart.add.item');
Route::post('/carrinho/editar-item','site\shopCartController@editQntyItemToCart')->name('cart.edit.item');
Route::post('/carrinho/deletar-item','site\shopCartController@deleteItemToCart')->name('cart.delete.item');

////----------  Demands ------------////
Route::get('/pedidos','site\UserSiteDemandController@viewAllDemandsByUser')->name('demands.view');
////----------  Check-Out ------------////
Route::get('/pedido/finalizar','site\shopCartController@checkOutCart')->name('cart.checkout');
////---------- notifications ------------////
Route::get('/send-message/whatsapp/{demand}','site\notificationController@sendMessageWhatsApp')->name('message.whatsapp');
Route::get('/send-message/whatsapp-demand/{demand}','site\notificationController@sendMessageWhatsAppDemand')->name('message.whatsapp.demand');

////----------- Payments -----------////
////----------- Payment on Delivery -----------////
Route::post('/pedido/criar-pedido','site\UserSiteDemandController@createDemand')->name('demand.create');

////----------- PayPal -----------////
Route::get('/paypal/pagar','site\paypalPaymentController@create')->name('paypal.pay');
Route::get('/paypal/execute-payment','site\paypalPaymentController@payPalStatus')->name('paypal.execute');
Route::get('/paypal/cancel','site\paypalPaymentController@payPalStatus')->name('cancel');

Route::get('usuario/politica-privacidade','site\UsersSiteController@userPolicy')->name('usersite.policy');
Route::get('usuario/termos','site\UsersSiteController@userTerms')->name('usersite.terms');

////----------- Users Site -----------////
Route::get('usuario/login','site\UsersSiteController@loginUserSite')->name('usersite.login');
Route::get('usuario/sair', 'site\UsersSiteController@logoutUserSite')->name('usersite.logout');
Route::post('usuario/login/email','site\UsersSiteController@loginWithEmail')->name('usersite.login.email');

Route::get('usuario/login/facebook', 'site\UsersSiteController@redirectToProviderFacebook')->name('usersite.login.facebook');
Route::get('usuario/login/facebook/callback', 'site\UsersSiteController@handleProviderCallbackFacebook')->name('facebook.callback');

Route::get('usuario/login/google', 'site\UsersSiteController@redirectToProviderGoogle')->name('usersite.login.google');
Route::get('usuario/login/google/callback', 'site\UsersSiteController@handleProviderCallbackGoogle')->name('google.callback');

Route::get('usuario/cadastro','site\UsersSiteController@createUserSite')->name('usersite.create');
Route::post('usuario/salvar','site\UsersSiteController@storeUserSite')->name('usersite.store');


////-------- Shop Stores -------////
//Route::get('/{segment}', 'site\pageSegmentsController@showStoresBySegment')->name('segment.page');
//Route::get('/{segment}/{category}', 'site\pageSegmentsController@showStoresBySegmentByCategory')->name('segment.category.page');

//Route::get('/{segment}/loja/{store}', 'site\pageStoresController@showStore')->name('store.page');
//Route::get('/{segment}/loja/{store}/{category}', 'site\pageStoresController@showStoreByCategory')->name('store.category.page');


//Route::get('/{segment}/loja/{store}/produto/{id}', 'site\shopCartController@addToCart')->name('cart.add');
//Route::get('/{segment}/loja/{store}/produto/{id}', 'site\ProductController@index')->name('product.index');


//Route::match(['get', 'post'], '/{segment}/{category}', 'site\pageSegmentsController@showStoresBySegmentByCategory')->name('segment.category.page');
//Route::get('/home', 'HomeController@index')->name('home');
