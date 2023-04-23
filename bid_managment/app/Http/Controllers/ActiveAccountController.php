<?php

namespace App\Http\Controllers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Contracts\Directs;
use App\BID\Repositories\ActiveRepository;
use App\BID\Repositories\DirectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveAccountController extends Controller
{
    private DirectRepository $directRepository;
    private ActiveRepository $activeRepository;
    private ActiveAccount $activeAccountService;
    private array $activeAccount = [];

    public function __construct(
        ActiveAccount $activeAccount
    ) {
        $this->directRepository = new DirectRepository();
        $this->activeRepository = new ActiveRepository();
        $this->activeAccountService = $activeAccount;
    }

    private function prepareActiveAccount(Request $request)
    {
        $accounts = $this->activeAccountService->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountForUser(Auth::user()->id)
        );

        $this->activeAccount = $this->activeAccountService->chooseOnceActiveAccountByRequest($accounts, $request->get('id'));

        return $accounts;
    }

    public function index(
        Directs $direct,
        Request $request
    ) {
        $accounts = $this->prepareActiveAccount($request);
        $compaigns = $this->activeAccountService->prepareCampaigns($direct, $this->activeAccount['access_token']);

        return response(compact('compaigns'));
    }

    public function getCampaigns(
        Directs $direct,
        Request $request
    ) {
        $accounts = $this->prepareActiveAccount($request);
        $compaigns = $this->activeAccountService->prepareCampaigns($direct, $this->activeAccount['access_token']);
        return response(compact('compaigns'));
    }

    public function getAdGroups(
        Directs $direct,
        Request $request
    ) {
        $accounts = $this->prepareActiveAccount($request);
        $adGroups = $this->activeAccountService->prepareAdGroups($direct, $this->activeAccount['access_token']);
        return response(compact('adGroups'));
    }

    public function getKeywords(
        Directs $direct,
        Request $request
    ) {
        $accounts = $this->prepareActiveAccount($request);
        $keywords = $this->activeAccountService->prepareKeywords($direct,$this->activeAccount['access_token']);
        return response(compact('keywords'));
    }
}
