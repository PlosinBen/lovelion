<?php

namespace App\Repository;

use App\Exceptions\EntityNotExistException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

class Repository
{
    protected Model $Model;
    protected int $perPage = 10;
    protected array $withTables = [];

    public function with(string $table): self
    {
        $this->withTables[] = $table;

        return $this;
    }

    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function find(int $id): ?Model
    {
        $model = clone $this->Model;
        if (count($this->withTables)) {
            $model = $model->with($this->withTables);
        }

        return $model->find($id);
    }

    /**
     * @param array|SupportCollection $columns
     * @return Collection
     */
    public function fetch($columns): Collection
    {
        return $this->modelSetFilter(collect($columns))->get();
    }

    /**
     * @param array|SupportCollection $columns
     * @return LengthAwarePaginator
     */
    public function fetchPagination($columns): LengthAwarePaginator
    {
        return $this->modelSetFilter(collect($columns))->paginate($this->perPage);
    }

    /**
     * @param SupportCollection $columns
     * @return Builder|Model
     */
    protected function modelSetFilter(SupportCollection $columns)
    {
        $query = clone $this->Model;

        $orderBy = $columns->pull('orderBy');
        if ($orderBy !== null) {
            $orderBy = is_array($orderBy) ? $orderBy : explode(',', $orderBy);
            foreach ($orderBy as $orderColumn) {
                $orderColumn = explode(' ', trim($orderColumn));
                $orderColumn[1] = strtolower($orderColumn[1]) === 'desc' ? 'DESC' : 'ASC';

                $query = $query->orderBy(parseSnakeCase($orderColumn[0]), $orderColumn[1]);
            }
        }

        $columns->map(function ($value, $scopeName) use (&$query) {
            $scopeName = parseCameCase($scopeName);
            if (method_exists($this->Model, 'scope'.ucfirst($scopeName))) {
                $query = call_user_func([$query, $scopeName], $value);
            }
        });

        if (count($this->withTables)) {
            $query = $query->with($this->withTables);
        }

        return $query;
    }

    public function insert($columns): Model
    {
        return $this->Model->create($columns);
    }

    /**
     * @param int|Model $id
     * @param SupportCollection $columns
     * @return Model
     * @throws EntityNotExistException
     */
    public function update($id, SupportCollection $columns): Model
    {
        $entity = $id instanceof Model ? $id : $this->find($id);
        if ($entity === null) {
            throw new EntityNotExistException;
        }

        $this
            ->setEntityColumns($entity, $columns)
            ->save();

        return $entity;
    }

    /**
     * @param Model $entity
     * @param array|\Illuminate\Support\Collection $columns
     * @return Model
     */
    protected function setEntityColumns(Model $entity, $columns): Model
    {
        foreach ($columns as $columnName => $value) {
            $entity->__set(parseSnakeCase($columnName), $value);
        }

        return $entity;
    }
}
