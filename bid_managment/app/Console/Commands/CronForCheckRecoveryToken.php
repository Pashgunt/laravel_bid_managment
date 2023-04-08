<?php

namespace App\Console\Commands;

use App\BID\Repositories\RecoveryTokenRepository;
use Illuminate\Console\Command;

class CronForCheckRecoveryToken extends Command
{
    
    protected $signature = 'token:validate';

    protected $description = 'validate tokens for auth';

    public function handle(): void
    {
        $date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . '-5 minutes'));
        (new RecoveryTokenRepository())->checkVaidTokenByDate($date);
    }
}
