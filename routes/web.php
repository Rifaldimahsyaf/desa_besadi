<?php

use Illuminate\Support\Facades\Log; // <- pastikan ini ada
use Illuminate\Support\Facades\Route;

$router->group(['namespace' => '\App\Http\Controllers'], function() use ($router){
    $router->get('', 'AuthController@viewLogin');
    $router->get('login', 'AuthController@viewLogin');
    $router->post('login', 'AuthController@actionLogin');

    $router->group(['middleware' => 'preventBackTab'], function () use ($router) {
        $router->get('logout', 'AuthController@logout');

        // Warga routes ...
        $router->get('warga', 'WargaController@viewWarga');
        $router->get('warga/list', 'WargaController@showWargaAjax');
        $router->post('warga', 'WargaController@create');
        $router->post('warga-update', 'WargaController@update');
        $router->get('warga/update/{id}', 'WargaController@viewUpdateWarga');
        $router->post('warga-delete', 'WargaController@delete');

        // Inventaris routes ...
        $router->get('inventaris', 'InventarisController@viewInventaris');
        $router->get('inventaris/list', 'InventarisController@showInventarisAjax');
        $router->post('inventaris', 'InventarisController@create');
        $router->post('inventaris-update', 'InventarisController@update');
        $router->get('inventaris/update/{id}', 'InventarisController@viewUpdateInventaris');
        $router->post('inventaris-delete', 'InventarisController@delete');

        // Import Excel Inventaris with logging example
       $router->post('inventaris/import', [
    'as'   => 'inventaris.import',
    'uses' => 'InventarisController@import',
]);
        // ... routes lainnya
    });
});
