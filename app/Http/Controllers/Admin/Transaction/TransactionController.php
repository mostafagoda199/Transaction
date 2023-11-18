<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Domain\Service\Interfaces\ITransactionService;
use App\Domain\Service\Interfaces\IUserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function __construct(
        private readonly IUserService $userService,
        private readonly ITransactionService $transactionService
    ){
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('viewAny', [Transaction::class]);
        $transactions = $this->transactionService->listTransactions();
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('create', [Transaction::class]);
        $customers = $this->userService->listCustomers();
        return view('admin.transactions.create', compact('customers'));
    }

    public function store(TransactionRequest $transactionRequest): RedirectResponse
    {
        $this->transactionService->storeTransaction($transactionRequest->validated());
        Session::flash('success', 'Transaction created successfully.');
        return redirect()->route('transactions.index');
    }
}
