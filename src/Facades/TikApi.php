<?php

namespace NeedLaravelSite\TikApi\Facades;

use Illuminate\Support\Facades\Facade;

class TikApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tikapi'; // matches alias in ServiceProvider
    }
}