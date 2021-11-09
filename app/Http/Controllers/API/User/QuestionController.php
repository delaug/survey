<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\QuestionIndexRequest;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\User\QuestionIndexRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(QuestionIndexRequest $request)
    {
        $validatedRequest = $request->validated();

        $questions = Question::with([
            'answers' => fn($q) => $q->where(['answers.user_id' => auth('sanctum')->id()]),
            'fields'
        ])
            ->where(['survey_id' => $validatedRequest['survey_id']])
            ->orderBy('sort')
            ->get();

        return response()->json($questions, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $question = Question::with(['answers','fields'])->findOrFail($id);

        return response()->json($question, Response::HTTP_OK);
    }
}
