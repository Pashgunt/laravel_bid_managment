<?php

namespace App\Jobs;

use App\BID\Repositories\ActiveRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ActiveAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ActiveRepository $activeRepository;
    private int $userID;
    private int $accountID;

    public function __construct(int $userID, int $accountID)
    {
        $this->activeRepository = new ActiveRepository();
        $this->userID = $userID;
        $this->accountID = $accountID;
    }

    public function handle(): void
    {
        $this->activeRepository->makeActiveAccountForUser($this->userID, $this->accountID);
    }
}
