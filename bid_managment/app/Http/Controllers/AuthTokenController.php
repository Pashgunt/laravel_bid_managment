<?php

namespace App\Http\Controllers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Contracts\Directs;
use App\BID\Repositories\ActiveRepository;
use App\BID\Repositories\DirectRepository;
use App\Http\Requests\Api\ValidateCodeDirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthTokenController extends Controller
{

    private DirectRepository $directRepository;
    protected ActiveRepository $activeRepository;

    public function __construct()
    {
        $this->directRepository = new DirectRepository();
        $this->activeRepository = new ActiveRepository();
    }

    public function index()
    {
        return view('direct.index');
    }

    public function list(ActiveAccount $activeAccount)
    {
        $prepareAccountsData = $activeAccount->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountFroUser(Auth::user()->id)
        );
        return view('direct.list', ['accounts' => $prepareAccountsData]);
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
