<?php

namespace robertogallea\LaravelGreenPass\Facades;

class GreenPass extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'greenpass';
    }
}