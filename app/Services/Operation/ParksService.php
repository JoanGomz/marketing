<?php

namespace App\Services\Operation;

use App\Models\Operation\Parks;
use App\Services\BaseService;

class ParksService extends BaseService
{
    public function __construct(Parks $parks)
    {
        parent::__construct($parks);
    }
}
