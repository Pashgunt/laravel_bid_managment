<?php

namespace App\BID\Contracts;

interface Compaign
{
    public function prepareCompaignIDs(array $compaigns = []);
}
