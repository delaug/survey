<?php

namespace App\Http\Controllers\API\User;

use App\Facades\User\AppFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $surveys = AppFacade::getSurveys();
        return response()->json($surveys, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $survey = AppFacade::getSurvey($id);
        return response()->json($survey, Response::HTTP_OK);
    }

}
