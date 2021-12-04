<?php

namespace App\Facades\User;

use Illuminate\Support\Facades\Facade;

/**
 * @method static int getNextQuestionPageID(int $survey_id)
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator getSurveys()
 * @method static mixed getSurvey(int $id)
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator getQuestions(\App\Http\Requests\User\QuestionIndexRequest $request)
 * @method static array setAnswer(\App\Http\Requests\User\AnswerStoreRequest $request)
 * @see \App\Services\User\AppService
 */
class AppFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AppService';
    }
}
