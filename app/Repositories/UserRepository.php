<?php
// app/Repositories/UserRepository.php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAllUsers($sortField, $sortOrder = 'asc')
    {
        return User::orderBy($sortField, $sortOrder)->simplePaginate(7);
    }

    public function getUserById($userId)
    {
        return User::find($userId);
    }

    public function createUser($userData)
    {
        return User::create($userData);
    }

    public function updateUser($userId, $userData)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update($userData);
            return $user;
        }
        return null;
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
