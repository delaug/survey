<?php

namespace App\Http\Controllers\API\User;

use App\Facades\User\AppFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AnswerStoreRequest;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\User\AnswerStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AnswerStoreRequest $request)
    {
        $data = AppFacade::setAnswer($request);
        return response()->json($data, Response::HTTP_OK);
    }
}
