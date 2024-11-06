<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Inertia\Inertia;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());
        return redirect()->route($result['user']->role->name == 'Администратор' ? 'admin.dashboard' : 'user.dashboard');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return redirect('/login')->with('message', 'Logged out successfully');
    }
}
