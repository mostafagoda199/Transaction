<?php

namespace App\Domain\Service\Classes;

use App\Domain\Service\Interfaces\IPermissionService;
use Illuminate\Support\Facades\Cache;

class PermissionService implements IPermissionService
{

    public function checkPermission(string $key): bool
    {
        if (! $this->getUserPermissions()->contains($key)) {
            return false;
        }
        return true;
    }

    public function getUserPermissions(): mixed
    {
        return auth()->user()?->role?->permissions()->pluck('key');
    }
}
