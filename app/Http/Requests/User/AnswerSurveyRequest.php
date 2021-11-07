<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AnswerSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_id' => ['required','exists:questions,id'],
            'answer_id' => ['required','exists:answers,id'],
            'answers' => ['required','array','min:1'],
            'answers.*.field_id' => ['required','exists:fields,id'],
            'answers.*.type_id' => ['required','exists:question_types,id'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'question_id.required' => 'Question ID is required',
            'question_id.exists' => 'Question ID doesn\'t exists',
            'answer_id.required' => 'Answer ID is required',
            'answer_id.exists' => 'Answer ID doesn\'t exists',
            'answers.*.field_id.required' => 'Field ID is required',
            'answers.*.field_id.exists' => 'Field ID doesn\'t exists',
            'answers.*.type_id.required' => 'Type ID is required',
            'answers.*.type_id.exists' => 'Type ID doesn\'t exists',
        ];
    }
}
