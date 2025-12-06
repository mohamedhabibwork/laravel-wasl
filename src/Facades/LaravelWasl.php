<?php

namespace Habib\LaravelWasl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Habib\LaravelWasl\LaravelWasl
 */
class LaravelWasl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Habib\LaravelWasl\LaravelWasl::class;
    }
}
