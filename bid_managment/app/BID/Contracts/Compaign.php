<?php

namespace App\BID\Contracts;

use Closure;

interface Compaign
{
    public function piplineHandler($request, Closure $next);
}
