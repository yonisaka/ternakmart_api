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

    //Controller Ternak
    $router->get('ternak', 'TernakController@index');
    $router->get('ternak/{id}', 'TernakController@show');
    $router->post('ternak', 'TernakController@store');
    $router->put('ternak/{id}', 'TernakController@update');
    $router->delete('ternak/{id}', 'TernakController@destroy');

    //Controller Golongan
    $router->get('golongan', 'GolonganController@index');
    //Controller Jenis
    $router->get('jenis', 'JenisController@index');
    $router->get('jenis/{id_golongan}/{jenis_kelamin}', 'JenisController@show');

    //Controller Pemeriksaan
    $router->get('pemeriksaan/{id}', 'PemeriksaanController@show');
    $router->post('pemeriksaan', 'PemeriksaanController@store');
    $router->put('pemeriksaan/{id}', 'PemeriksaanController@update');
});

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});