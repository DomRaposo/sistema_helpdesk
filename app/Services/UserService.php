<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers()
    {
        return $this->userRepository->getAll();
    }

    public function register(array $data)
    {
        // Criptografa a senha antes de salvar
        $data['password'] = Hash::make($data['password']);

        // Chama o repositório para criar o usuário
        return $this->userRepository->create($data);
    }
}
