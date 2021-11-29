<?php

namespace App\Services\Admin;



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
    public function all()
    {
        return Question::withType()->paginate(request()->input('per_page',$this->paginate_per_page));
    }

    /**
     * Create
     *
     * @param StoreQuestionRequest $request
     * @return mixed
     */
    public function create(StoreQuestionRequest $request)
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
    public function get(Question $question)
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
    public function update(UpdateQuestionRequest $request, Question $question)
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
    public function delete(Question $question)
    {
        $question->delete();
        return true;
    }
}
