<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
            'latestAnswer'
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
        $survey = Survey::with([
            'questions' => fn($q) => $q
                ->select(['id', 'text', 'sort', 'survey_id', 'type_id'])
                ->withCount(['fields']),
            'questions.type:id,name',
            'questions.fields:id,text,question_id',
            'user:id,name,email',
            'user.roles:id,name',
            'answers'
        ])
            ->has('answers')
            ->withCount('questions')
            ->findOrFail($id);

        return response()->json($survey, Response::HTTP_OK);
    }

    /**
     * Take specified survey.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function take(int $id) {
        $user = auth('sanctum')->user();

        $answer = Answer::firstOrCreate([
            'user_id' => $user->id,
            'survey_id' => $id
        ]);

        return response()->json($answer, Response::HTTP_OK);
    }
}
