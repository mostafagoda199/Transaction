<?php

namespace App\Domain\Injectors;

use App\Domain\Policies\TransactionPolicy;
use App\Models\Transaction;
use App\Providers\AuthServiceProvider;

class PolicyInjector extends AuthServiceProvider
{

    protected $policies = [
        Transaction::class => TransactionPolicy::class
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
