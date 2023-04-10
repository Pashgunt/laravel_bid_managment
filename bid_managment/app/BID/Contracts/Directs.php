<?php

namespace App\BID\Contracts;

use App\Models\DirectToken;
use Illuminate\Http\Request;

interface Directs
{
    public function generateDirectCode(Request $request, DirectToken $raw): int;
    public function getCompaigns();
}
