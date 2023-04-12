<?php

namespace App\BID\Contracts;

interface AdGroup
{
    public function prepareAdGroupIDs(array $adGroups = []);
}
