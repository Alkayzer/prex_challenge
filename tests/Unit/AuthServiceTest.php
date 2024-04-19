<?php

namespace Tests\Unit;

use App\Services\LogService;
use Tests\TestCase;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpPassportClients();
        $this->logServiceMock = \Mockery::mock(LogService::class)->makePartial();
    }

    public function test_signup_creates_a_user_and_returns_a_token()
    {
        $this->logServiceMock->shouldReceive('createLog')->once();

        $authService = new AuthService($this->logServiceMock);

        $email = "test@example.com";
        $name = "Test User";
        $password = "password";

        $response = $authService->signup($email, $name, $password);

        $this->assertDatabaseHas('users', ['email' => $email, 'name' => $name]);
        $user = User::first();
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertIsString($response);
    }

    public function test_login_returns_a_token_on_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        $authService = new AuthService($this->logServiceMock);

        $this->logServiceMock->shouldReceive('createLog')
            ->once()
            ->withArgs([
                $user->id,
                'authService.login',
                \Mockery::any(),
                200
            ]);

        $response = $authService->login('test@example.com', 'password');

        $this->assertNotNull($response);
        $this->assertIsString($response);
    }

    public function test_login_fails_on_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        $authService = new AuthService($this->logServiceMock);

        $response = $authService->login('test@example.com', 'wrongpassword');

        $this->assertNull($response);
    }
}
