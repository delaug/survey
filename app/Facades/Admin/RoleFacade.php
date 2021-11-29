<?php

namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\Admin\RoleService
 */
class RoleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'RoleService';
    }
}
