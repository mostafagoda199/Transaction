<?php

namespace App\Domain\Service\Interfaces;

interface IPermissionService
{
    public function checkPermission(string $key): bool;
}
