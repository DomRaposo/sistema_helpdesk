<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function getAll($orderBy = 'asc')
    {
        return $this->orderBy('name', $orderBy)->get();
    }

    public function create(array $data)
    {
        // Cria e retorna o usuário no banco de dados
        return User::create($data);
    }
}
