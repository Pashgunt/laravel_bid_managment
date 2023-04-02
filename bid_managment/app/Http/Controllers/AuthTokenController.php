<?php

namespace App\Http\Controllers;

use App\BID\Repositories\DirectRepository;
use App\Http\Requests\ValidateCodeDirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthTokenController extends Controller
{

    private DirectRepository $directRepository;

    public function __construct()
    {
        $this->directRepository = new DirectRepository();
    }

    public function index()
    {
        return view('direct.index');
    }

    public function list()
    {
        return view('direct.list', ['requests' => $this->directRepository->getAlRequests()]);
    }

    public function store(ValidateCodeDirect $validate)
    {
        $DTO = $validate->makeDTO();
        $this->directRepository->createNewDirectCodesForRequests($DTO);
        return redirect(route('auth-request'));
    }

    public function direct(Request $request)
    {
        $clientID = $_COOKIE['client_id'];
        $raw = $this->directRepository->getDataForPrepareTokenByClientId($clientID);

        $clientID = $raw->client_id;
        $clientSecret = $raw->client_secret;

        $exitCode = Artisan::call('app:girect-get-auth', [
            'code' => $request->get('code') ?? 0,
            'client_id' => $clientID,
            'client_secret' => $clientSecret
        ]);

        if (!$exitCode) {
            return redirect(route('auth-list-requests'))->with('message', 'Error');
        }

        return redirect(route('auth-list-requests'));
    }
}
