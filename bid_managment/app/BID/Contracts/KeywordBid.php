<?php

namespace App\BID\Contracts;

use Closure;

interface KeywordBid
{
    public function piplineHandler($request, Closure $next);
}
