<?php

namespace App\Services\User;

use App\Http\Requests\User\AnswerStoreRequest;
use App\Http\Requests\User\QuestionIndexRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;

class AppService
{
    /**
     * Get next page number for paginator
     * Search question where no exist user answers and get index element (equals page)
     *
     * TODO: Late think about it
     *
     * @param int $survey_id
     * @return int
     */
    public function getNextQuestionPageID(int $survey_id): int
    {
        $id = Question::withCount(['userAnswers'])
            ->where(['survey_id' => $survey_id])
            ->orderBy('sort')
            ->get()
            ->search(function ($value) {
                return $value->user_answers_count == 0;
            });

        // if index 0 return first page
        return $id ? $id + 1 : 1;
    }

    /**
     * Get all Surveys with paginate
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSurveys()
    {
        return Survey::with([
            'user:id,name,email',
            'user.roles:id,name'
        ])
            ->whereNotNull('publish_at')
            ->withCount('questions')
            ->orderByDesc('publish_at')
            ->paginate(5);
    }

    /**
     * Get concrete Survey
     *
     * @param int $id
     * @return mixed
     */
    public function getSurvey(int $id)
    {
        return Survey::withCount(['questions'])
            ->whereNotNull('publish_at')
            ->findOrFail($id);
    }

    /**
     * Get all Questions with paginate
     *
     * @param QuestionIndexRequest $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getQuestions(QuestionIndexRequest $request)
    {
        $validatedRequest = $request->validated();

        // Check page or get next question where empty user answers
        $page = !(int)$validatedRequest['question']
            ? self::getNextQuestionPageID($validatedRequest['survey_id'])
            : null;

        return Question::with([
            'answers' => fn($q) => $q->where(['answers.user_id' => auth('sanctum')->id()]),
            'fields'
        ])
            ->where(['survey_id' => $validatedRequest['survey_id']])
            ->orderBy('sort')
            ->paginate(1, ['*'], 'question', $page);
    }

    /**
     * Set user Answer
     *
     * @param AnswerStoreRequest $request
     * @return array
     */
    public function setAnswer(AnswerStoreRequest $request)
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
