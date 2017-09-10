<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Aws\Sns\SnsClient;
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
            'profile' => 'smsConfirmAPI'
        ]);

    }

    public function index()
    {
        $teste = Teste::all();
        return response()->json($teste);
    }


}
