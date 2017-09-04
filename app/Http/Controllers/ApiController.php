<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {

        return response()->json(

            $data,
            $this->getStatusCode(),
            $headers

        );
    }

    /**
     * @param $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk($message, $data = [])
    {
        return $this->setStatusCode(200)->respond($message,$data);
    }


    /**
     * @param $error
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($error, $data = [])
    {

        return $this->respond(

            [
                'message' => $error ,
                'errorDescription' =>  $data
            ]

        );
    }

    /**
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found!', $data = [])
    {

        return $this->setStatusCode(404)->respondWithError($message,$data);

    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnauthorized($message = 'Not authorized!')
    {

        return $this->setStatusCode(401)->respondWithError($message);

    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return $this
     *
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

}
