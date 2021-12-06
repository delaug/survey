<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required','string','max:255'],
            'description' => ['required','string','max:255'],
            'user_id' => ['required','exists:users,id'],
            'media_id' => ['nullable','exists:media,id'],
            'is_publish' => ['boolean'],
        ];
    }
}
