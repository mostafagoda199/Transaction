<?php

namespace App\Domain\Injectors;

use App\Domain\Repositories\Classes\PaymentRepository;
use App\Domain\Repositories\Classes\PermissionRepository;
use App\Domain\Repositories\Classes\RoleRepository;
use App\Domain\Repositories\Classes\TransactionRepository;
use App\Domain\Repositories\Classes\UserRepository;
use App\Domain\Repositories\Interfaces\IPaymentRepository;
use App\Domain\Repositories\Interfaces\IPermissionRepository;
use App\Domain\Repositories\Interfaces\IRoleRepository;
use App\Domain\Repositories\Interfaces\ITransactionRepository;
use App\Domain\Repositories\Interfaces\IUserRepository;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Providers\AppServiceProvider;

class RepositoryInjector extends AppServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton(IUserRepository::class, function () {
            return new UserRepository(new User());
        });

        $this->app->singleton(ITransactionRepository::class, function () {
            return new TransactionRepository(new Transaction());
        });

        $this->app->singleton(IRoleRepository::class, function () {
            return new RoleRepository(new Role());
        });

        $this->app->singleton(IPermissionRepository::class, function () {
            return new PermissionRepository(new Permission());
        });

        $this->app->singleton(IPaymentRepository::class, function () {
            return new PaymentRepository(new Payment());
        });
    }
}
