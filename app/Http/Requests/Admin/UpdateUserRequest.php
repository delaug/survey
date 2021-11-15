<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'id' => ['required', 'exists:users,id'],
            'name' => ['nullable','string','max:255'],
            'email' => ['nullable','email','string','max:255','unique:users,email,'.request()->id],
            'password' => ['nullable','string','min:6'],
            'role_ids.*' => ['required','exists:roles,id'],
        ];
    }
}
