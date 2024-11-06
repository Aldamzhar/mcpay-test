<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
        Cache::flush();
    }

    public function test_it_retrieves_all_users_with_caching()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);
        User::factory(10)->create(['role_id' => $role->id]);

        $users = $this->userService->getAllUsers();
        $this->assertCount(10, $users);
        $this->assertTrue(Cache::has('users'));
    }

    public function test_it_retrieves_user_by_id_with_caching()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $retrievedUser = $this->userService->getUserById($user->id);
        $this->assertEquals($user->id, $retrievedUser->id);
        $this->assertTrue(Cache::has("user_{$user->id}"));
    }

    public function test_it_creates_user_and_invalidates_cache()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);

        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'role_id' => $role->id,
            'password' => 'password123'
        ];

        $user = $this->userService->createUser($userData);
        $this->assertInstanceOf(User::class, $user);
        $this->assertFalse(Cache::has('users'));
    }

    public function test_it_updates_user_and_invalidates_cache()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $updatedData = [
            'name' => 'Updated Name',
            'password' => 'newpassword'
        ];

        $updatedUser = $this->userService->updateUser($user->id, $updatedData);
        $this->assertEquals('Updated Name', $updatedUser->name);
        $this->assertTrue(Hash::check('newpassword', $updatedUser->password));
        $this->assertFalse(Cache::has("user_{$user->id}"));
    }

    public function test_it_deletes_user_and_invalidates_cache()
    {
        $role = Role::factory()->create(['name' => 'Пользователь']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $result = $this->userService->deleteUser($user->id);
        $this->assertTrue($result);
        $this->assertNull(User::find($user->id));
        $this->assertFalse(Cache::has("user_{$user->id}"));
    }
}
