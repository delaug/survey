<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\QuestionIndexRequest;
use App\Http\Services\User\AppService;
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
        $questions = AppService::getQuestions($request);
        return response()->json($questions, Response::HTTP_OK);
    }
}
