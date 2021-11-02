<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
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
        $surveys = Survey::withCount('questions')->paginate(5);
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
        $survey = Survey::with([
            'questions' => fn($q) => $q
                ->select(['id', 'text', 'sort', 'survey_id', 'type_id'])
                ->withCount(['fields']),
            'questions.type:id,name',
            'questions.fields:id,text,question_id',
        ])
            ->withCount('questions')
            ->findOrFail($id);


        return response()->json($survey, Response::HTTP_OK);
    }
}
