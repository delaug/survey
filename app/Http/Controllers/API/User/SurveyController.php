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
        $surveys = Survey::paginate(5);
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
                ->select(['id', 'text', 'sort', 'survey_id'])
                ->withCount(['fields']),
            'questions.fields:id,sort,type_id,question_id',
            'questions.fields.type:id,name,description',
        ])
            ->withCount('questions')
            ->findOrFail($id);


        return response()->json($survey, Response::HTTP_OK);
    }
}
