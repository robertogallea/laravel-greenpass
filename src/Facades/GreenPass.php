<?php

namespace robertogallea\LaravelGrenPass\Facades;

class GreenPass extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'greenpass';
    }
}