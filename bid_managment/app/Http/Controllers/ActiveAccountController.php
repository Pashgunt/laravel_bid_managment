<?php

namespace App\Http\Controllers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Contracts\Directs;
use App\BID\Repositories\ActiveRepository;
use App\BID\Repositories\DirectRepository;
use App\BID\Services\YandexAdGroup;
use App\BID\Services\YandexCompaign;
use App\BID\Services\YandexKeyword;
use App\BID\Services\YandexKeywordBid;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class ActiveAccountController extends Controller
{
    private DirectRepository $directRepository;
    private ActiveRepository $activeRepository;
    private array $activeAccount = [];

    public function __construct()
    {
        $this->directRepository = new DirectRepository();
        $this->activeRepository = new ActiveRepository();
    }

    public function index(
        ActiveAccount $activeAccount,
        Directs $direct,
        Request $request
    ) {

        $accounts = $activeAccount->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountForUser(Auth::user()->id)
        );

        $this->activeAccount = $activeAccount->chooseOnceActiveAccountByRequest($accounts, $request->post('id'));

        $compaigns = $activeAccount->prepareCampaigns($direct, $this->activeAccount['access_token']);

        return response(compact('accounts', 'compaigns'));
    }
}
