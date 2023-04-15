<?php

namespace App\Http\Controllers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Contracts\AdGroup;
use App\BID\Contracts\Compaign;
use App\BID\Contracts\Directs;
use App\BID\Contracts\Keyword;
use App\BID\Repositories\ActiveRepository;
use App\BID\Repositories\DirectRepository;
use App\BID\Services\YandexAdGroup;
use App\BID\Services\YandexCompaign;
use App\BID\Services\YandexKeyword;
use App\BID\Services\YandexKeywordBid;
use Closure;
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
        Directs $direct
    ) {

        $accounts = $activeAccount->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountFroUser(Auth::user()->id)
        );

        foreach ($accounts as $accountData) {
            if ($accountData['selected']) {
                $this->activeAccount = $accountData;
            }
        }

        // TODO make this in Bus
        $compaigns = app(Pipeline::class)
            ->send([])
            ->through([
                new YandexCompaign($direct->getCompaigns($this->activeAccount['access_token'])),
                function ($request, Closure $next) use ($direct) {
                    return $next((new YandexAdGroup($direct->getAdGroups(
                            $this->activeAccount['access_token'],
                            [
                                "CampaignIds" => array_keys($request),
                            ]
                        )))->piplineHandler($request, $next)
                    );
                },
                function ($request, Closure $next) use ($direct) {
                    return $next((new YandexKeyword($direct->getKeywords(
                        $this->activeAccount['access_token'],
                        [
                            'AdGroupIds' => $request['adGroupIDs'],
                            'CampaignIds' => $request['campaignIDs'],
                        ]
                    )))->piplineHandler($request, $next));
                },
                function ($request, Closure $next) use ($direct) {
                    return $next((new YandexKeywordBid($direct->getKeywordBids(
                        $this->activeAccount['access_token'],
                        [
                            'AdGroupIds' => $request['adGroupIDs'],
                            'CampaignIds' => $request['campaignIDs'],
                            "KeywordIds" => $request['keywordIDs'],
                            "ServingStatuses" => ["ELIGIBLE", "RARELY_SERVED"],
                        ]
                    )))->piplineHandler($request, $next));
                },
            ])
            ->via('piplineHandler')
            ->thenReturn();


        return view('active.active', compact('accounts', 'compaigns'));
    }
}
