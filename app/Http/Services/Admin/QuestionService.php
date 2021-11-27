<?php

namespace App\Http\Services\Admin;



use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Question;

class QuestionService extends BaseService
{
    /**
     * All
     *
     * @return Question[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function all()
    {
        return Question::withType()->paginate(request()->input('per_page',self::$paginate_per_page));
    }

    /**
     * Create
     *
     * @param StoreQuestionRequest $request
     * @return mixed
     */
    public static function create(StoreQuestionRequest $request)
    {
        $data = $request->validated();
        $question = Question::create($data);

        return Question::withType()->find($question->id);
    }

    /**
     * Get
     *
     * @param Question $question
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public static function get(Question $question)
    {
        return Question::withType()->find($question->id);
    }

    /**
     * Update
     *
     * @param UpdateQuestionRequest $request
     * @param Question $question
     * @return mixed
     */
    public static function update(UpdateQuestionRequest $request, Question $question)
    {
        $data = $request->validated();
        $question->update($data);

        $question = Question::withType()->find($question->id);

        return $question;
    }

    /**
     * Delete
     *
     * @param Question $question
     * @return bool
     */
    public static function delete(Question $question)
    {
        $question->delete();
        return true;
    }
}
