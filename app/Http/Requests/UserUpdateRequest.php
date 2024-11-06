<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user') ?? $this->route('id');

        return [
            'name'     => 'sometimes|required|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $userId,
            'password' => 'sometimes|nullable|min:6',
            'role_id'  => 'sometimes|required|exists:roles,id',
        ];
    }
}
