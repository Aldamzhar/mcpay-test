<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    public function test_it_logs_in_user_with_valid_credentials()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id
        ]);

        $credentials = ['email' => 'user@example.com', 'password' => 'password123'];

        $response = $this->authService->login($credentials);
        $this->assertEquals($user->id, $response['user']->id);
    }

    public function test_it_throws_validation_exception_for_invalid_credentials()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id
        ]);

        $credentials = ['email' => 'user@example.com', 'password' => 'wrongpassword'];

        $this->expectException(ValidationException::class);
        $this->authService->login($credentials);
    }

    public function test_it_logs_out_user()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $user->tokens()->create([
            'name' => 'Test Token',
            'token' => 'test-token',
            'abilities' => ['*']
        ]);

        $this->authService->logout($user);
        $this->assertEmpty($user->tokens);
    }
}
