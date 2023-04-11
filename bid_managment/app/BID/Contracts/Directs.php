<?php

namespace App\BID\Contracts;

use App\Models\DirectToken;
use Illuminate\Http\Request;

interface Directs
{
    public function generateDirectCode(Request $request, DirectToken $raw): int;
    public function getCompaigns(string $accessToken, array $selectionCriteria = [], array $fieldNames = ['Id', 'Name']);
    public function getAdGroups(string $accessToken, array $selectionCriteria = [], array $fieldNames = ["CampaignId", "Id", "Name"]);
}
