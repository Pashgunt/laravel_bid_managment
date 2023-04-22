<?php

namespace App\Http\Controllers\Api;

use App\BID\Repositories\ActiveRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValidateMakeInnactive;
use App\Jobs\ActiveAccountJob;
use App\Jobs\InnactiveAllAccountJob;
use Illuminate\Support\Facades\Bus;

class ApiAccountActive extends Controller
{

    private ActiveRepository $activeRepository;

    public function __construct()
    {
        $this->activeRepository = new ActiveRepository();
    }

    public function storeInnactive(ValidateMakeInnactive $request)
    {
        $vaidated = $request->validated();
        if ($this->activeRepository->makeInnactiveAccountForUser($vaidated['user_id'])) {
            return response('ok', 200);
        }
        return response('ok', 403);
    }

    public function storeActive(ValidateMakeInnactive $request)
    {
        $vaidated = $request->validated();

        // TODO get result from BUS chain and transmit in React
        Bus::chain([
            new InnactiveAllAccountJob($vaidated['user_id']),
            new ActiveAccountJob($vaidated['user_id'], $vaidated['account_id']),
        ])->dispatch();

        return response('ok', 200);
    }
}
