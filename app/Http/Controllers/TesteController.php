<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Teste;

/**
 * Class TokenController
 * @package App\Http\Controllers
 */
class TesteController extends ApiController
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $loggedUser;


    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }

    public function index()
    {

        return response()->json(config());
    }


}
