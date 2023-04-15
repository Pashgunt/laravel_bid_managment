<?php

namespace App\BID\Contracts;

use Closure;

interface AdGroup
{
    public function piplineHandler($request, Closure $next);
}
