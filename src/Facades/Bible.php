<?php

namespace Bishopm\Bible\Facades;

use Illuminate\Support\Facades\Facade;

class Bible extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'bible';
    }
}
