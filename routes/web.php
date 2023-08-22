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

$router->group(['namespace' => '\App\Http\Controllers'], function() use ($router){
    $router->get('', 'AuthController@viewLogin');
    $router->get('login', 'AuthController@viewLogin');
    $router->post('login', 'AuthController@actionLogin');

    $router->group(['middleware' => 'preventBackTab'], function () use ($router) {
        $router->get('logout', 'AuthController@logout');

        //purchase
        $router->get('purchase', 'PurchaseController@viewPurchase');
        $router->get('purchase/list', 'PurchaseController@showPurchaseAjax');
        $router->post('purchase', 'PurchaseController@create');
        $router->post('purchase-update', 'PurchaseController@update');
        $router->get('purchase/update/{id}', 'PurchaseController@viewUpdatePurchase');
        $router->post('purchase-delete', 'PurchaseController@delete');

        //supplier
        $router->get('supplier', 'SupplierController@viewSupplier');
        $router->get('supplier/list', 'SupplierController@showSupplierAjax');
        $router->post('supplier', 'SupplierController@create');
        $router->post('supplier-update', 'SupplierController@update');
        $router->get('supplier/update/{id}', 'SupplierController@viewUpdateSupplier');
        $router->post('supplier-delete', 'SupplierController@delete');

        //product
        $router->get('product', 'ProductController@viewProduct');
        $router->get('product/list', 'ProductController@showProductAjax');
        $router->post('product', 'ProductController@create');
        $router->post('supplier-update', 'SupplierController@update');
        $router->get('supplier/update/{id}', 'SupplierController@viewUpdateSupplier');
        $router->post('supplier-delete', 'SupplierController@delete');
        
    });
});