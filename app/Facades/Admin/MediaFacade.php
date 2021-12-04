<?php

namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\Admin\FieldService
 */
class MediaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MediaService';
    }
}
