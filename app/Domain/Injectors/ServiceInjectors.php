<?php

namespace App\Domain\Injectors;

use App\Domain\Service\Classes\AuthService;
use App\Domain\Service\Classes\PaymentService;
use App\Domain\Service\Classes\PermissionService;
use App\Domain\Service\Classes\RoleService;
use App\Domain\Service\Classes\TransactionService;
use App\Domain\Service\Classes\UserService;
use App\Domain\Service\Interfaces\IAuthService;
use App\Domain\Service\Interfaces\IPaymentService;
use App\Domain\Service\Interfaces\IPermissionService;
use App\Domain\Service\Interfaces\IRoleService;
use App\Domain\Service\Interfaces\ITransactionService;
use App\Domain\Service\Interfaces\IUserService;
use App\Domain\Shared\Responder\Classes\ApiHttpResponder;
use App\Domain\Shared\Responder\Interfaces\IApiHttpResponder;
use App\Providers\AppServiceProvider;

class ServiceInjectors extends AppServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton(IApiHttpResponder::class, ApiHttpResponder::class);
        $this->app->singleton(IAuthService::class, AuthService::class);
        $this->app->singleton(IPermissionService::class, PermissionService::class);
        $this->app->singleton(IRoleService::class, RoleService::class);
        $this->app->singleton(IUserService::class, UserService::class);
        $this->app->singleton(ITransactionService::class, TransactionService::class);
        $this->app->singleton(IPaymentService::class, PaymentService::class);
    }
}
