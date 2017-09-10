<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Aws\Sns\SnsClient;
use App\Token;

/**
 * Class TokenController
 * @package App\Http\Controllers
 */
class TokenController extends ApiController
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $loggedUser;

    /**
     * @var SnsClient
     */
    protected $snsClient;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->loggedUser = Auth::user();

        $this->snsClient = new SnsClient([

            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => 'AKIAIRXD7257I5YUCMFQ',
                'secret' => '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'
            ]
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {

        $phoneNumber = (string)( $request->input('phoneNumber'));

        if( empty($phoneNumber) )
        {
            return $this->respondWithError(
                [
                    'message' => 'phoneNumber must be provided',
                    'messageCode' => '3'
                ]
            );
        }

        $token = $this->createToken($phoneNumber);

        $this->snsClient->publish([

            'Message' => $token . ' is your activation code',
            'PhoneNumber' => $phoneNumber

        ]);


        $modelToken = new Token;

        $modelToken->phone = $phoneNumber;
        $modelToken->token = $token;
        $modelToken->user_id = $this->loggedUser->id;
        $modelToken->validated = false;

        $modelToken->save();

        return $this->respondOk([

            'message' => 'token sended',
            'messageCode' => '0',
            'token' => $token

        ]);

    }

    /**
     * @param $telefone
     * @param $typed_token
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkToken($telefone, $typed_token)
    {

        $token = new Token;

        $phoneExistis = Token::where('phone',$telefone)->where('validated',false)->first();

        if($phoneExistis === NULL || $phoneExistis->count() < 0)
        {
            return $this->respondWithError([
                'message' => 'No new confirmation messages has been sent to this phone number',
                'messageCode' => '4'
            ]);

        }

        $found = $token->checkToken($this->loggedUser, $telefone, $typed_token);

        if ( $found === NULL ||  $found->count() < 0 )
        {
            return $this->respondWithError(

                [
                    'message' => 'token incorrect',
                    'messageCode' => '2'
                ]

            );

        }

        $found->validated = true;

        $found->save();

        return $this->respondOk(

            [
                'message' => 'token validated' ,
                'messageCode' => '1'
            ]

        );
    }

    /**
     * @return string
     */
    private function createToken() : string
    {
        return substr(md5(uniqid(rand(), true)), 0, 7);
    }


}
