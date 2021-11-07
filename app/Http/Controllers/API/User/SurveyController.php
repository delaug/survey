<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AnswerSurveyRequest;
use App\Models\Answer;
use App\Models\Field;
use App\Models\Question;
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
            'answer',
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
            'questions.fields.answers',
            'user:id,name,email',
            'user.roles:id,name',
            'answer',
        ])
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
    public function take(int $id)
    {
        $user = auth('sanctum')->user();

        $answer = Answer::firstOrCreate([
            'user_id' => $user->id,
            'survey_id' => $id
        ]);

        return response()->json($answer, Response::HTTP_OK);
    }

    /**
     * Answer.
     *
     * @param AnswerSurveyRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function answer(AnswerSurveyRequest $request, int $id)
    {
        $data = $request->validated();

        $syncData = [];

        foreach ($data['answers'] as $answer) {
            $syncData[$answer['field_id']] = [
                'question_id' => $data['question_id'],
                'value' => $answer['value'] ?? null
            ];
        }

        $result = Answer::find($data['answer_id'])
            ->fields()
            ->sync($syncData);

        $ids = array_merge($result['attached'], $result['updated']);

        $question = Question::with([
            'type:id,name',
            'fields:id,text,question_id',
            'fields.answers',
        ])
            ->select(['id', 'text', 'sort', 'survey_id', 'type_id'])
            ->withCount(['fields'])->findOrFail($data['question_id']);


        return response()->json($question, Response::HTTP_OK);
    }
}
