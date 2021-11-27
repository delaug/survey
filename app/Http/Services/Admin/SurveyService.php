<?php

namespace App\Http\Services\Admin;

use App\Http\Requests\Admin\StoreSurveyRequest;
use App\Http\Requests\Admin\UpdateSurveyRequest;
use App\Models\Question;
use App\Models\Survey;

class SurveyService extends BaseService
{
    /**
     * All
     *
     * @return Survey[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function all()
    {
        return Survey::withUser()->paginate(request()->input('per_page', self::$paginate_per_page));
    }

    /**
     * Create
     *
     * @param StoreSurveyRequest $request
     * @return mixed
     */
    public static function create(StoreSurveyRequest $request)
    {
        $data = $request->validated();

        $data['publish_at'] = $data['is_publish'] ? now() : null;
        $survey = Survey::create($data);

        return Survey::withUser()->find($survey->id);
    }

    /**
     * Get
     *
     * @param Survey $survey
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public static function get(Survey $survey)
    {
        return Survey::withUser()->find($survey->id);
    }

    /**
     * Update
     *
     * @param UpdateSurveyRequest $request
     * @param Survey $survey
     * @return mixed
     */
    public static function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $data = $request->validated();

        if($survey->publish_at && !$data['is_publish'])
            $data['publish_at'] = null;
        elseif (!$survey->publish_at)
            $data['publish_at'] = now();

        $survey->update($data);

        $survey = Survey::withUser()->find($survey->id);
        return $survey;
    }

    /**
     * Delete
     *
     * @param Survey $survey
     * @return bool
     */
    public static function delete(Survey $survey)
    {
        $survey->delete();
        return true;
    }

    /**
     * Questions
     *
     * @param Survey $survey
     * @return mixed
     */
    public static function getQuestions(Survey $survey)
    {
        $questions = Question::with([
            'fields'
        ])
            ->where('survey_id', $survey->id)
            ->get();
        return $questions;
    }
}
