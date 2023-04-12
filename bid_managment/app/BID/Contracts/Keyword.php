<?php

namespace App\BID\Contracts;

interface Keyword
{
    public function prepareKeywordIDs(array $keywords = []);
}
