<?php

namespace App\Http\Controllers;

use App\BID\Contracts\Directs;
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

    public function direct(Request $request, Directs $direct)
    {
        $raw = $this->directRepository->getDataForPrepareTokenByClientId($_COOKIE['client_id']);
        $exitCode = $direct->generateDirectCode($request, $raw);

        if (!$exitCode) return redirect(route('auth-list-requests'))->with('message', 'Error');

        return redirect(route('auth-list-requests'));
    }
}
