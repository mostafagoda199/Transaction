<?php

namespace App\Domain\Service\Classes;

use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Domain\Service\Interfaces\IAuthService;
use App\Exceptions\ApiCustomException;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthService implements IAuthService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {
    }

    /**
     * @throws Throwable
     */
    public function loginUser(array $requestData): array
    {
        $user = $this->userRepository->firstOrFail(conditions: ['email' => $requestData['email']]);

        $checkPassword = Hash::check($requestData['password'], $user->password);
        throw_if(! $checkPassword, new ApiCustomException(message: trans('message.user.invalid_user')));
        $token = $user->createToken($user->name);
        return [
            'user' => $user->fresh(),
            'token' => $token,
        ];
    }
}
