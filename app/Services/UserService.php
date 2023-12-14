<?php
// app/Services/UserService.php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($sortField, $sortOrder = 'asc')
    {
        return $this->userRepository->getAllUsers($sortField, $sortOrder);
    }

    public function getUserById($userId)
    {
        return $this->userRepository->getUserById($userId);
    }

    public function createUser($userData)
    {
        return $this->userRepository->createUser($userData);
    }

    public function updateUser($userId, $userData)
    {
        return $this->userRepository->updateUser($userId, $userData);
    }

    public function deleteUser($userId)
    {
        return $this->userRepository->deleteUser($userId);
    }
}
