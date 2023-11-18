<?php

namespace App\Domain\Policies;

use App\Domain\Service\Interfaces\IPermissionService;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    private const PREFIX_PERMISSION_KEY = 'transaction-';

    public function __construct(private readonly IPermissionService $permissionService)
    {
    }

    public function viewAny(): bool
    {
        return $this->permissionService->checkPermission(self::PREFIX_PERMISSION_KEY . 'index');
    }

    public function create(): bool
    {
        return $this->permissionService->checkPermission(self::PREFIX_PERMISSION_KEY . 'create');
    }
}
