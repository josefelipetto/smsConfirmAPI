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

/**
 * @SWG\Swagger(schemes={"http"}, basePath="api/v1",
 *     @SWG\Info(version="1.0.0", title="SMS User Confirmation API"))
 */
$app->group(['prefix' => 'api/v1'], function() use ($app){

    /**
     * @SWG\Post(
     *      path="/token/{api_token}",
     *      tags={"token"},
     *      operationId="sendToken",
     *      summary="Send a new token to a given phone number",
     *      @SWG\Parameter(
     *          name="phoneNumber",
     *          in="body",
     *          required=true
     *      ),
     * @SWG\Response(
     *     status=200,
     *     description="success"
     * ),
     * @SWG\Response(
     *     status=401,
     *     description="Unauthorized"
     * ),
     * @SWG\Response(
     *     status=500,
     *     description="Internal error. Check if you sent phoneNumber on the request"
     * )
     *
     * )
     */
    $app->post('token/{api_token}','TokenController@send');

    /**
     * @SWG\Get(
     *     path="/token/{api_token}/{phoneNumber}/{typedToken},
     *     operationId="checkToken",
     *     summary="Checks if a token is valid for a given phoneNumber",
     *     @SWG\Parameter(
     *      name="phoneNumber",
     *      in="path",
     *      required=true
     *      ),
     *     @SWG\Parameter(
     *      name="typedToken",
     *      in="path",
     *      required=true
     *      )
     * )
     */
    $app->get('token/{api_token}/{telefone}/{typed_token}', 'TokenController@checkToken');

});


