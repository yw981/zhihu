<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => 'required|min:3',
            'password'  => 'required|min:3',
            'password_confirmation'  => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => '必须输入旧密码！',
            'password.required' => '必须输入新密码！',
            'password_confirmation.same' => '两次输入新密码不一致！',
        ];
    }
}
