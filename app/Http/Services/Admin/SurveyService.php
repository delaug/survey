<?php

namespace App\Http\Services\Admin;

use App\Http\Requests\Admin\StoreSurveyRequest;
use App\Http\Requests\Admin\UpdateSurveyRequest;
use App\Models\Survey;

class SurveyService
{
    /**
     * All
     *
     * @return Survey[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function all()
    {
        return Survey::all();
    }

    /**
     * Create
     *
     * @param StoreSurveyRequest $request
     * @return mixed
     */
    public static function create(StoreSurveyRequest $request)
    {
        return Survey::create($request->validated());
    }

    /**
     * Get
     *
     * @param Survey $survey
     * @return Survey
     */
    public static function get(Survey $survey)
    {
        return $survey;
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
        $survey->update($request->validated());

        $survey = Survey::find($survey->id);
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
}
