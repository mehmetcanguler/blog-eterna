<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Internal\AuthService;
use App\Support\Helpers\ApiResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        $this->authService->register($request->toDto());

        return ApiResponse::success();
    }

    public function login(LoginRequest $request)
    {
        return ApiResponse::item(
            $this->authService->login($request->toDto())
        );
    }

    public function logout()
    {
        $this->authService->logout();

        return ApiResponse::success();
    }
}
