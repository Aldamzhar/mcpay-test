<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Services\UserService;
use Inertia\Inertia;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function adminDashboard()
    {
        $users = $this->userService->getAllUsers();
        return Inertia::render('Admin/Dashboard', ['users' => $users, 'roles' => Role::all()]);
    }

    public function user()
    {
        $user = $this->userService->user();
        return Inertia::render('User/Profile', ['user' => $user]);
    }

    public function store(UserStoreRequest $storeRequest)
    {
        $this->userService->createUser($storeRequest->all());

        return redirect()->route('admin.dashboard');
    }

    public function update(UserUpdateRequest $updateRequest, $id)
    {
        $user = $this->userService->updateUser($id, $updateRequest->all());

        return $user ? redirect()->route('admin.dashboard') : response()->json(['error' => 'User not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->userService->deleteUser($id);

        return $deleted ? redirect()->route('admin.dashboard') : response()->json(['error' => 'User not found'], 404);
    }
}
