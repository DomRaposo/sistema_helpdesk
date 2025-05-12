<?php

namespace App\Repositories;

class BaseRepository
{
    private $model;

    public function __construct($model)
    {
        $this->model = app($model);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $model = $this->model->find($id);
        return $model->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function paginate($perPage)
    {
        return $this->model->paginate($perPage);
    }

    public function where($column, $value)
    {
        return $this->model->where($column, $value);
    }

    public function whereIn($column, $value)
    {
        return $this->model->whereIn($column, $value);
    }

    public function whereNotIn($column, $value)
    {
        return $this->model->whereNotIn($column, $value);
    }

    public function whereBetween($column, $value)
    {
        return $this->model->whereBetween($column, $value);
    }

    public function whereNotBetween($column, $value)
    {
        return $this->model->whereNotBetween($column, $value);
    }

    public function whereNull($column)
    {
        return $this->model->whereNull($column);
    }

    public function whereNotNull($column)
    {
        return $this->model->whereNotNull($column);
    }

    public function whereDate($column, $value)
    {
        return $this->model->whereDate($column, $value);
    }

    public function whereColumn($column, $operator, $value)
    {
        return $this->model->whereColumn($column, $operator, $value);
    }

    public function whereRaw($sql, $bindings)
    {
        return $this->model->whereRaw($sql, $bindings);
    }

    public function orderBy($column, $direction)
    {
        return $this->model->orderBy($column, $direction);
    }

    public function groupBy($column)
    {
        return $this->model->groupBy($column);
    }

    public function having($column, $operator, $value)
    {
        return $this->model->having($column, $operator, $value);
    }

    public function havingRaw($sql, $bindings)
    {
        return $this->model->havingRaw($sql, $bindings);
    }

    public function count()
    {
        return $this->model->count();
    }

    public function sum($column)
    {
        return $this->model->sum($column);
    }

    public function avg($column)
    {
        return $this->model->avg($column);
    }

    public function min($column)
    {
        return $this->model->min($column);
    }

    public function max($column)
    {
        return $this->model->max($column);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function get()
    {
        return $this->model->get();
    }

    public function pluck($column)
    {
        return $this->model->pluck($column);
    }

    public function toArray()
    {
        return $this->model->toArray();
    }

    public function toJson()
    {
        return $this->model->toJson();
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function withCount($relations)
    {
        return $this->model->withCount($relations);
    }

    public function withTrashed()
    {
        return $this->model->withTrashed();
    }

    public function onlyTrashed()
    {
        return $this->model->onlyTrashed();
    }

    public function limit($limit)
    {
        return $this->model->limit($limit);
    }

    public function offset($offset)
    {
        return $this->model->offset($offset);
    }

    public function increment($id, $column, $findBy, $amount = 1)
    {
        $query = (new $this->model);

        $model = $query->where($findBy, $id)->first();

        if ($model) {
            return $model->increment($column, $amount);
        }
        return false;
    }

}
