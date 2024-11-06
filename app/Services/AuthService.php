<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();


        if (!Auth::attempt($data)) {
            throw ValidationException::withMessages([
                'email' => ['Введенные данные неверны'],
            ]);
        }

        Auth::login($user);
        return ['user' => $user];
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }
}

