<?php

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

$app->get('teste', 'TesteController@index');

$app->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function() use ($app){

    $app->post('token','TokenController@send');

    $app->get('token/{telefone}/{typed_token}', 'TokenController@checkToken');

});


