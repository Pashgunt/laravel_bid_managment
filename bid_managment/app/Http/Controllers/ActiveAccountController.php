<?php

namespace App\Http\Controllers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Repositories\ActiveRepository;
use App\BID\Repositories\DirectRepository;
use Illuminate\Support\Facades\Auth;

class ActiveAccountController extends Controller
{

    private DirectRepository $directRepository;
    private ActiveRepository $activeRepository;

    public function __construct()
    {
        $this->directRepository = new DirectRepository();
        $this->activeRepository = new ActiveRepository();
    }

    public function index(ActiveAccount $activeAccount)
    {        
        $prepareAccountsData = $activeAccount->prepareSelectedActiveAccount(
            $this->directRepository->getAlRequests(),
            $this->activeRepository->getActiveAccountFroUser(Auth::user()->id)
        );

        return view('active.active', ['accounts' => $prepareAccountsData]);
    }
}
