<?php

namespace App\Http\Controllers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Contracts\Compaign;
use App\BID\Contracts\Directs;
use App\BID\Repositories\ActiveRepository;
use App\BID\Repositories\DirectRepository;
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

    public function index(ActiveAccount $activeAccount, Directs $direct, Compaign $compaign)
    {

        $prepareAccountsData = $activeAccount->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountFroUser(Auth::user()->id)
        );

        foreach ($prepareAccountsData as $accountData) {
            if ($accountData['selected']) {
                $this->activeAccount = $accountData;
            }
        }

        $compaigns = $direct->getCompaigns($this->activeAccount['access_token']);

        if ($compaigns) $compaigns = $compaigns['result'];

        $compainIDs = $compaign->prepareCompaignIDs($compaigns);

        dd($direct->getAdGroups($this->activeAccount['access_token'], [
            "CampaignIds" => $compainIDs
        ]));

        return view('active.active', [
            'accounts' => $prepareAccountsData,
            'compaigns' => $compaigns
        ]);
    }
}
