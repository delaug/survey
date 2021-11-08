<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'survey_id' => ['required','exists:surveys,id'],
            'user_id' => ['required','exists:users,id'],
            'question_id' => ['required','exists:questions,id'],
            'field_id' => ['required','exists:fields,id'],
            'text' => ['nullable'],
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
            'survey_id.required' => 'Survey ID is required',
            'survey_id.exists' => 'Survey ID doesn\'t exists',
            'user_id.required' => 'User ID is required',
            'user_id.exists' => 'User ID doesn\'t exists',
            'question_id.required' => 'Question ID is required',
            'question_id.exists' => 'Question ID doesn\'t exists',
            'field_id.required' => 'Field ID is required',
            'field_id.exists' => 'Field ID doesn\'t exists',
        ];
    }
}
