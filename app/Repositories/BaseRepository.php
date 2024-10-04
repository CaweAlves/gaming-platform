<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\{Collection, Model};

class BaseRepository
{
    public function __construct(protected Model $model)
    {
    }

    public function find(int $id): Model|null
    {
        return $this->model->find($id);
    }

    public function findAll(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->find($id)->update($data);
    }

    public function delete(int $id): bool|null
    {
        return $this->find($id)->delete();
    }
}
