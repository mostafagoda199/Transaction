<?php

namespace App\Domain\Repositories\Classes;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class AbstractRepository
{
    /**
     * @param Model $model
     */
    public function __construct(
        protected Model $model
    ) {
    }

    public function firstOrFail(array $conditions = [],array $relations = [])
    {
        return $this->prepareQuery(conditions: $conditions,relations: $relations)->firstOrFail();
    }

    /**
     * @param array $conditions
     * @param array $relations
     * @param array $select
     * @param string $orderBy
     * @param string $orderType
     * @param array $orConditions
     * @return array|Collection
     */
    public function listAllBy(array $conditions = [], array $relations = [], array $select = ['*'], string $orderBy = 'id', string $orderType = 'DESC', array $orConditions = []): array|Collection
    {
        return $this->prepareQuery(conditions: $conditions,relations:  $relations, select: $select)->orderBy($orderBy, $orderType)->get();
    }

    public function retrieve(array $conditions = [], array $relations = [], array $select = ['*'], string $orderBy = 'id'): LengthAwarePaginator
    {
        return $this->prepareQuery(conditions: $conditions, relations: $relations, select: $select)->orderBy($orderBy)->paginate(request('paginate') ?? 10);
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * @param array $conditions
     * @param array $relations
     * @param array $select
     * @return Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function prepareQuery(array $conditions = [], array $relations = [], array $select = ['*']): Builder|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model
            ->with($relations)
            ->where($conditions)
            ->select($select);
    }
}
