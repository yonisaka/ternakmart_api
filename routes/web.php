<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/users
    $router->post('users', 'AuthController@register');
 
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // navigation
    $router->get('nav/{role_id}', 'AuthController@navigation');
    // auth
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    // $router->get('profile', 'UserController@profile');

    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');
    $router->delete('users/{id}', 'UserController@destroy');
    $router->post('users', 'UserController@store');
    $router->put('users/{id}', 'UserController@update');

    //Controller Ternak
    $router->get('ternak', 'TernakController@index');
    $router->get('ternak/{id}', 'TernakController@show');
    $router->post('ternak', 'TernakController@store');
    $router->put('ternak/{id}', 'TernakController@update');
    $router->delete('ternak/{id}', 'TernakController@destroy');
    $router->get('cariternak', 'TernakController@search');

    //Controller Golongan
    $router->get('golongan', 'GolonganController@index');
    $router->get('golongan/{id}', 'GolonganController@show');
    //Controller Jenis
    $router->get('jenis', 'JenisController@index');
    $router->get('jenis/{id_golongan}/{jenis_kelamin}', 'JenisController@show');
    $router->get('jenis/{id}', 'JenisController@detail');

    //Controller menu
    $router->get('menu', 'MenuController@index');
    $router->get('menu/{id}', 'MenuController@show');
    $router->put('menu/{id}', 'MenuController@update');

    //Controller role
    $router->get('role', 'RoleController@index');
    $router->get('role_menu', 'RoleController@role_menu');
    $router->get('role/{id}', 'RoleController@show');
    $router->put('role/{id}', 'RoleController@update');
    $router->delete('role_menu/{role_id}/{menu_id}', 'RoleController@destroy');

    //Controller Pemeriksaan
    $router->get('pemeriksaan', 'PemeriksaanController@index');
    $router->get('pemeriksaan/{id}', 'PemeriksaanController@show');
    $router->get('pemeriksaan/{id}/detail', 'PemeriksaanController@detail');
    $router->post('pemeriksaan', 'PemeriksaanController@store');
    $router->put('pemeriksaan/{id}', 'PemeriksaanController@update');

    //Controller Dokter
    $router->get('dokter', 'DokterController@index');
    $router->get('dokter/{id}', 'DokterController@show');
    $router->delete('dokter/{id}', 'DokterController@destroy');
    $router->post('dokter', 'DokterController@store');
    $router->put('dokter/{id}', 'DokterController@update');
    
    //Controller penjual
    $router->get('penjual', 'PenjualController@index');
    $router->get('penjual/{id}', 'PenjualController@show');
    $router->delete('penjual/{id}', 'PenjualController@destroy');
    $router->post('penjual', 'PenjualController@store');
    $router->put('penjual/{id}', 'PenjualController@update');

    //Controller customer
    $router->get('customer', 'CustomerController@index');
    $router->get('customer/{id}', 'CustomerController@show');
    $router->delete('customer/{id}', 'CustomerController@destroy');
    $router->post('customer', 'CustomerController@store');
    $router->put('customer/{id}', 'CustomerController@update');
    
    //Controller Transaksi
    $router->post('transaksi', 'TransaksiController@store');
    $router->get('transaksi', 'TransaksiController@index');
    $router->get('transaksi/{id}', 'TransaksiController@show');

});

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});