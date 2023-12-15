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

    /**
     * show all users on the base of sorting and pagination.
    */
    public function getAllUsers($sortField, $sortOrder = 'asc', $search = [])
    {
        return $this->userRepository->getAllUsers($sortField, $sortOrder, $search);
    }
    public function getAllRoles()
    {
        return $this->userRepository->getAllRoles();
    }

    /**
     * Details of a specific user.
    */
    public function getUserById($userId)
    {
        return $this->userRepository->getUserById($userId)->load('roles');
    }

    /**
     * create a new user.
    */
    public function createUser($userData)
    {
        return $this->userRepository->createUser($userData);
    }

    /**
     * update  a specific user.
    */
    public function updateUser($userId, $userData)
    {
        return $this->userRepository->updateUser($userId, $userData);
    }

    /**
     * delete a specific user.
    */
    public function deleteUser($userId)
    {
        return $this->userRepository->deleteUser($userId);
    }
}
