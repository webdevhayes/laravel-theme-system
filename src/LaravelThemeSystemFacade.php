<?php

namespace Webdevhayes\LaravelThemeSystem;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Webdevhayes\LaravelThemeSystem\LaravelThemeSystem
 */
class LaravelThemeSystemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-theme-system';
    }
}
