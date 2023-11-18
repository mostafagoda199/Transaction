<?php

namespace App\Domain\Service\Interfaces;

interface IAuthService
{
    public function loginUser(array $requestData);
}
