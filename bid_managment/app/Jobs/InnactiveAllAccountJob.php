<?php

namespace App\Jobs;

use App\BID\Repositories\ActiveRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InnactiveAllAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ActiveRepository $activeRepository;
    private int $userID;

    public function __construct(int $userID)
    {
        $this->activeRepository = new ActiveRepository();
        $this->userID = $userID;
    }

    public function handle(): void
    {
        $this->activeRepository->makeInnactiveAccountForUser($this->userID);
    }
}
