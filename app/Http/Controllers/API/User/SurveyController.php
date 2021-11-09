<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Survey;
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
        $surveys = Survey::with([
            'user:id,name,email',
            'user.roles:id,name',
        ])->withCount('questions')->paginate(5);
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
        $survey = Survey::findOrFail($id);
        return response()->json($survey, Response::HTTP_OK);
    }

}
