<?php

namespace App\BID\Contracts;

use Closure;

interface Keyword
{
    public function piplineHandler($request, Closure $next);
}
