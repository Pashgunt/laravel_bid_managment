<?php

namespace App\Http\Controllers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Contracts\AdGroup;
use App\BID\Contracts\Compaign;
use App\BID\Contracts\Directs;
use App\BID\Contracts\Keyword;
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

    public function index(
        ActiveAccount $activeAccount,
        Directs $direct,
        Compaign $compaign,
        AdGroup $adGroup,
        Keyword $keyword
    ) {

        $prepareAccountsData = $activeAccount->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountFroUser(Auth::user()->id)
        );

        foreach ($prepareAccountsData as $accountData) {
            if ($accountData['selected']) {
                $this->activeAccount = $accountData;
            }
        }

        // TODO make Pipline for prepare info about data

        $compaigns = $direct->getCompaigns($this->activeAccount['access_token']);

        if ($compaigns) $compaigns = $compaigns['result'];

        $compainIDs = $compaign->prepareCompaignIDs($compaigns);

        $adGroups = $direct->getAdGroups($this->activeAccount['access_token'], [
            "CampaignIds" => $compainIDs
        ]);

        if ($adGroups) $adGroups = $adGroups['result'];

        $adGroupIDs = $adGroup->prepareAdGroupIDs($adGroups);

        $keywords = $direct->getKeywords($this->activeAccount['access_token'], [
            'AdGroupIds' => $adGroupIDs,
            'CampaignIds' => $compainIDs,
        ]);

        if ($keywords) $keywords = $keywords['result'];

        $keywordIDs = $keyword->prepareKeywordIDs($keywords);

        dd($direct->getKeywordBids($this->activeAccount['access_token'], [
            "CampaignIds" => $compainIDs,
            "AdGroupIds" => $adGroupIDs,
            "KeywordIds" => $keywordIDs,
            "ServingStatuses" => ["ELIGIBLE", "RARELY_SERVED"]
        ]));

        return view('active.active', [
            'accounts' => $prepareAccountsData,
            'compaigns' => $compaigns
        ]);
    }
}
