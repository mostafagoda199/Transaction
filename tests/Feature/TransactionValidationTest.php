<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;

use Tests\TestCase;

class TransactionValidationTest extends TestCase
{
    public function testCreateTransactionValidationAmountIsRequired()
    {
        $this->artisan('migrate:refresh', [
            '--seed' => true,
        ]);

        $adminRoleId = Role::where('slug', 'admin')->first()->id;

        $this->actingAs(User::where('role_id', $adminRoleId)->first());

        $data = [
            'payer' => 1,
            'due_on' => '15/01/2023',
            'vat' => 16,
            'is_vat_inclusive' => true
        ];
        $this->testCreateTransactionValidation($data,'amount');
    }

    public function testCreateTransactionValidationAmountIsNumeric()
    {
        $this->artisan('migrate:refresh', [
            '--seed' => true,
        ]);

        $adminRoleId = Role::where('slug', 'admin')->first()->id;

        $this->actingAs(User::where('role_id', $adminRoleId)->first());

        $data = [
            'amount' => 'asd',
            'payer' => 1,
            'due_on' => '15/01/2023',
            'vat' => 16,
            'is_vat_inclusive' => true
        ];
        $this->testCreateTransactionValidation($data,'amount');
    }

    public function testCreateTransactionValidationPayerIsRequired()
    {
        $this->artisan('migrate:refresh', [
            '--seed' => true,
        ]);

        $adminRoleId = Role::where('slug', 'admin')->first()->id;

        $this->actingAs(User::where('role_id', $adminRoleId)->first());

        $data = [
            'amount' => 'asd',
            'due_on' => '15/01/2023',
            'vat' => 16,
            'is_vat_inclusive' => true
        ];
        $this->testCreateTransactionValidation($data,'payer');
    }

    public function testCreateTransactionValidationVatIsRequired()
    {
        $this->artisan('migrate:refresh', [
            '--seed' => true,
        ]);

        $adminRoleId = Role::where('slug', 'admin')->first()->id;

        $this->actingAs(User::where('role_id', $adminRoleId)->first());

        $data = [
            'amount' => 'asd',
            'payer' => 1,
            'due_on' => '15/01/2023',
            'is_vat_inclusive' => true
        ];
        $this->testCreateTransactionValidation($data,'vat');
    }


    private function testCreateTransactionValidation(array $data, string $key): void
    {
        $response = $this->postJson('/transactions', $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            $key
        ]);
    }
}
