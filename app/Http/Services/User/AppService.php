<?php

namespace App\Http\Services\User;

use App\Http\Requests\User\AnswerStoreRequest;
use App\Http\Requests\User\QuestionIndexRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;

class AppService
{
    /**
     * Get all Surveys with paginate
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getSurveys()
    {
        return Survey::with([
            'user:id,name,email',
            'user.roles:id,name'
        ])->withCount('questions')->paginate(5);
    }

    /**
     * Get concrete Survey
     *
     * @param int $id
     * @return mixed
     */
    public static function getSurvey(int $id)
    {
        return Survey::withCount(['questions'])->findOrFail($id);
    }

    /**
     * Get all Questions with paginate
     *
     * @param QuestionIndexRequest $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public static function getQuestions(QuestionIndexRequest $request)
    {
        $validatedRequest = $request->validated();

        return Question::with([
            'answers' => fn($q) => $q->where(['answers.user_id' => auth('sanctum')->id()]),
            'fields'
        ])
            ->where(['survey_id' => $validatedRequest['survey_id']])
            ->orderBy('sort')
            ->paginate(1, ['*'], 'question');
    }

    /**
     * Get concrete Question
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public static function getQuestion(int $id)
    {
        return Question::with(['answers', 'fields'])->findOrFail($id);
    }

    /**
     * Set user Answer
     *
     * @param AnswerStoreRequest $request
     * @return array
     */
    public static function setAnswer(AnswerStoreRequest $request)
    {
        $validatedRequest = $request->validated();

        foreach ($validatedRequest as $data) {
            $tmp = [
                'survey_id' => $data['survey_id'],
                'user_id' => $data['user_id'],
                'question_id' => $data['question_id'],
                'field_id' => $data['field_id'],
            ];

            $answer = Answer::where($tmp)->first();

            if ($answer && empty($data['value'])) {
                $answer->delete();
            } elseif ($answer && $data['value'] != $answer->value) {
                $answer->update(['value' => $data['value']]);
            } else {
                Answer::create(array_merge($tmp, ['value' => $data['value']]));
            }
        }

        // Take result data from DB
        $question = Question::with(['answers', 'fields'])->findOrFail($validatedRequest[0]['question_id']);
        $answersToQuestionsCount = Survey::find($validatedRequest[0]['survey_id'])->answers_to_questions_count;

        return [
            'question' => $question,
            'answers_to_questions_count' => $answersToQuestionsCount
        ];
    }
}
