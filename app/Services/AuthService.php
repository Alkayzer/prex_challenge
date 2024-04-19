<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function signup(string $email, string $name, string $password ): string
    {
        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make($password),
        ]);

        $this->logService->createLog(
            $user->id,
            'authService.signup',
            json_encode(['email' => $email, 'name' => $name, 'password' => $password]),
            201,
        );

        return $user->createToken('Personal Access Token')->accessToken;
    }

    public function login(string $email, string $password): ?string
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return null;
        }

        $user = Auth::user();
        $this->logService->createLog(
            $user->id,
            'authService.login',
            json_encode(['email' => $email]),
            200
        );
        return $user->createToken('Personal Access Token')->accessToken;
    }

}
