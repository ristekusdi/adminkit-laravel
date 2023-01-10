<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RBAC extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rbac';
    }
}