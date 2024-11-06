<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UserService
{
    public function getAllUsers()
    {
        return Cache::remember('users', 600, function () {
            return User::with('role:id,name')->get();
        });
    }

    public function user()
    {
        return Auth::user();
    }

    public function createUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'password' => Hash::make($data['password']),
        ]);

        Cache::forget('users');

        return $user;
    }

    public function getUserById($id)
    {
        return Cache::remember("user_{$id}", 600, function () use ($id) {
            return User::with('role')->find($id);
        });
    }

    public function updateUser($id, array $data)
    {
        $user = User::find($id);
        if (!$user) {
            return null;
        }

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->fill($data);
        $user->save();

        Cache::forget('users');
        Cache::forget("user_{$id}");

        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return false;
        }

        $user->delete();

        Cache::forget('users');
        Cache::forget("user_{$id}");

        return true;
    }
}
