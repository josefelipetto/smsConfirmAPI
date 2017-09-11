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


$app->group(['prefix' => 'api/v1'], function() use ($app){

    $app->post('token/{api_token}','TokenController@send');

    $app->get('token/{api_token}/{telefone}/{typed_token}', 'TokenController@checkToken');

});


