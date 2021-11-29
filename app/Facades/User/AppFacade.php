<?php

namespace App\Facades\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\User\AppService
 */
class AppFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AppService';
    }
}
