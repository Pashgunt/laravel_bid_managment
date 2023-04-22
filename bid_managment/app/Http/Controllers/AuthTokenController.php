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
        $accounts = $activeAccount->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountFroUser(Auth::user()->id)
        );
        return response(compact('accounts'));
    }

    public function store(ValidateCodeDirect $validate)
    {
        $DTO = $validate->makeDTO();
        $code = $this->directRepository->createNewDirectCodesForRequests($DTO);
        return response(compact('code'));
    }

    public function direct(Request $request, Directs $direct)
    {
        $raw = $this->directRepository->getDataForPrepareTokenByClientId($request->input('client_id'));
        if ($raw) {
            $exitCode = $direct->generateDirectCode($request, $raw);

            if (!$exitCode) return response('ok', 200);

            return $this->prepareErrorResponse(['token' => ['Something going wrong']]);
        }

        return $this->prepareErrorResponse([
            'token' => ['Something going wrong']
        ]);
    }

    public function delete(Request $request)
    {
        $account = $this->directRepository->updateActualStatateForAccount($request->post('account_id'), 0);

        if ($account) {
            return response('ok', 200);
        }

        return $this->prepareErrorResponse(['result' => ['Something going wrong']]);
    }

    public function deleteCancel(Request $request)
    {
        $account = $this->directRepository->updateActualStatateForAccount($request->post('account_id'), 1);

        if ($account) {
            return response('ok', 200);
        }

        return $this->prepareErrorResponse(['result' => ['Something going wrong']]);
    }
}
