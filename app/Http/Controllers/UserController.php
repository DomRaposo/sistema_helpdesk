<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showUsers()
    {
        //$users = $this->userService->getUsers();
        $users = User::getAll();
        return response()->json($users);
    }

    public function register(Request $request)
    {
        // Valida os dados recebidos da requisição
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'tipo' => 'required|in:cliente,atendente,admin',
        ]);

        // Chama o service para criar o usuário
        $user = $this->userService->register($validated);

        // Retorna o usuário criado como resposta
        return response()->json($user, 201);
    }
}
