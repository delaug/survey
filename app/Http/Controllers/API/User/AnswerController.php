<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AnswerStoreRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\AnswerStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AnswerStoreRequest $request)
    {
        $validatedRequest = $request->validated();

        foreach ($validatedRequest as $data) {
            $tmp = [
                'survey_id' => $data['survey_id'],
                'user_id' => $data['user_id'],
                'question_id' => $data['question_id'],
                'field_id' => $data['field_id'],
            ];

            if(empty($data['value']))
                Answer::where($tmp)->delete();
            else
                Answer::updateOrCreate(array_merge($tmp,['value' => $data['value']]));
        }

        // Take result data from DB
        $question = Question::with(['answers','fields'])->findOrFail($validatedRequest[0]['question_id']);

        return response()->json($question, Response::HTTP_OK);
    }
}
