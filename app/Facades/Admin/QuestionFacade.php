<?php

namespace App\Facades\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\Admin\QuestionService
 */
class QuestionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QuestionService';
    }
}
