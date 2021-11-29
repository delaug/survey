<?php

namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\Admin\FieldService
 */
class FieldFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FieldService';
    }
}
