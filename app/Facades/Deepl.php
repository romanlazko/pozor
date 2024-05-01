<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Deepl extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'deepl';
    }
}
