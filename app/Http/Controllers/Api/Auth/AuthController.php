<?php

namespace App\Http\Controllers\Api\Auth;

use App\Domain\Service\Interfaces\IAuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;

class AuthController extends Controller
{
    /**
     * @param IAuthService $authService
     */
    public function __construct(private readonly IAuthService $authService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return AuthResource
     */
    public function login(LoginRequest $request): AuthResource
    {
        return new AuthResource($this->authService->loginUser($request->validated()));
    }
}
