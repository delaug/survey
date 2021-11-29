<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\Admin\SurveyFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSurveyRequest;
use App\Http\Requests\Admin\UpdateSurveyRequest;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Response;

class SurveyController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Survey::class, 'survey');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $surveys = SurveyFacade::all();
        return response()->json($surveys, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSurveyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSurveyRequest $request)
    {
        $survey = SurveyFacade::create($request);
        return response()->json($survey, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  Survey $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Survey $survey)
    {
        $survey = SurveyFacade::get($survey);
        return response()->json($survey, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSurveyRequest $request
     * @param  Survey $surveys
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $survey = SurveyFacade::update($request, $survey);
        return response()->json($survey, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Survey $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Survey $survey)
    {
        SurveyFacade::delete($survey);
        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * Return survey questions
     *
     * @param Survey $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexQuestions(Survey $survey)
    {
        $questions = SurveyFacade::getQuestions($survey);
        return response()->json($questions, Response::HTTP_OK);
    }
}
