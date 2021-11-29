<?php

namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\Admin\UserService
 */
class UserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'UserService';
    }
}
