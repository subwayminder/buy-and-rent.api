<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

abstract class CRUDService
{
    /**
     * @return Builder
     */
    abstract public function getBuilder(): Builder;

    /**
     * @param int $limit
     * @param string|array $orderBy
     * @param string $sortType
     * @param bool $returnBuilder
     * @return LengthAwarePaginator|Collection|Builder
     */
    public function getList(
        int          $limit = 0,
        string|array $orderBy = '',
        string       $sortType = 'asc',
        bool         $returnBuilder = false,
    ): LengthAwarePaginator|Collection|Builder {
        $builder = $this->getBuilder();

        /* Sorting */
        $builder = $this->withSorting($builder, $orderBy, $sortType);

        /* Pagination */
        return $returnBuilder ? $builder : $builder->paginate($this->getLimit($limit, $builder->count()));
    }
    protected function getLimit(int $limit, int $fullCount): int
    {
        return $limit === 0 ? $fullCount : $limit;
    }

    /**
     * @param Data $dto
     * @return Model
     */
    public function create(Data $dto): Model
    {
        return $this->getBuilder()->create($dto->toArray());
    }

    /**
     * @param int $id
     * @param Data $dto
     * @return Model
     */
    public function updateOrFail(int $id, Data $dto): Model
    {
        $model = $this->getBuilder()->findOrFail($id);
        $model->update(
            $dto->except('id')->toArray()
        );

        return $model;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroyOrFail(int $id): bool
    {
        return $this->getBuilder()->findOrFail($id)->delete();
    }

    /**
     * @param Builder $builder
     * @param string|array $orderBy
     * @param string $sortType
     * @return Builder
     */
    protected function withSorting(
        Builder      $builder,
        string|array $orderBy = '',
        string       $sortType = 'asc'
    ): Builder {
        if (is_array($orderBy) && count($orderBy) > 0) {
            foreach ($orderBy as $column => $direction) {
                if (is_string($column)) {
                    $builder->orderBy($column, $direction);
                } else {
                    $builder->orderBy($direction, $sortType);
                }
            }
        } elseif (is_string($orderBy) && empty($orderBy) === false) {
            $builder->orderBy($orderBy, $sortType);
        }

        return $builder;
    }
}
