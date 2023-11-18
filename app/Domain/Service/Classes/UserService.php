<?php

namespace App\Domain\Service\Classes;

use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Domain\Service\Interfaces\IUserService;
use Illuminate\Support\Collection;

class UserService implements IUserService
{
    public function __construct(private readonly IUserRepository $userRepository)
    {

    }

    public function listCustomers(): array|Collection
    {
       return $this->userRepository->listCustomers();
    }
}
