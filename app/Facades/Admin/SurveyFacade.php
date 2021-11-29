<?php

namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\Admin\SurveyService
 */
class SurveyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SurveyService';
    }
}
