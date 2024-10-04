<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\{Collection, Model};

interface IBaseRepository
{
    public function find(int $id): Model| null;

    public function findAll(): Collection;

    public function create(array $data): Model;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool|null;
}
