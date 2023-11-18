<?php

namespace App\Domain\Repositories\Classes;

use App\Domain\Repositories\Interfaces\IUserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends AbstractRepository implements IUserRepository
{

    public function listCustomers(): Collection|array
    {
        return $this->model->query()->whereHas('role', function ($query) {
            $query->where('slug', 'customer');
        })->get();
    }
}
