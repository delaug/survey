<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\Admin\QuestionFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Question::class, 'question');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $question = QuestionFacade::all();
        return response()->json($question, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = QuestionFacade::create($request);
        return response()->json($question, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  Question $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Question $question)
    {
        $question = QuestionFacade::get($question);
        return response()->json($question, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestionRequest $request
     * @param  Question $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question = QuestionFacade::update($request, $question);
        return response()->json($question, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Question $question)
    {
        QuestionFacade::delete($question);
        return response()->json(null, Response::HTTP_OK);
    }
}
