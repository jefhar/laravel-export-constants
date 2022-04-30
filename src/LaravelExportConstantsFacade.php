<?php

namespace LaravelExportConstants;

use Illuminate\Support\Facades\Facade;

class LaravelExportConstantsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-export-constants';
    }
}
