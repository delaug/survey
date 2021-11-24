<?php

namespace App\Http\Services\Admin;



use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Question;

class QuestionService
{
    /**
     * All
     *
     * @return Question[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function all()
    {
        return Question::get();
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

        return $question::find($question->id);
    }

    /**
     * Get
     *
     * @param Question $question
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public static function get(Question $question)
    {
        return Question::find($question->id);
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
        $question = Question::find($question->id);

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
