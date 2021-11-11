<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AnswerStoreRequest;
use App\Http\Services\User\AppService;
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
        $data = AppService::setAnswer($request);
        return response()->json($data, Response::HTTP_OK);
    }
}
