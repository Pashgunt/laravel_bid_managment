<?php

namespace App\Console\Commands;

use App\BID\Repositories\DirectRepository;
use App\Models\DirectToken;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetAccessTokenForDirect extends Command
{
    protected $signature = 'app:girect-get-auth {code} {client_id} {client_secret}';

    protected $description = 'make OAuth for next use acess token';

    public function handle(): void
    {
        try {
            $result = Http::asForm()->post('https://oauth.yandex.ru/token', [
                'grant_type' => 'authorization_code',
                'code' => trim($this->argument('code')),
                'client_id' => trim($this->argument('client_id')),
                'client_secret' => trim($this->argument('client_secret'))
            ]);

            if ($result->ok()) {
                $acessToken = $result->json()['access_token'];
                (new DirectRepository())->setAcessTokenByClientID(
                    trim($this->argument('client_id')),
                    trim($this->argument('code')),
                    $acessToken
                );
            }
        } catch (Exception $e) {
        }
    }
}
