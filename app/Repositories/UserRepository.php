<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAllUsers($sortField, $sortOrder = 'asc')
    {
        return User::orderBy($sortField, $sortOrder)->simplePaginate(7);
    }

    /**
     * Details of a specific user.
    */
    public function getUserById($userId)
    {
        return User::find($userId);
    }

    /**
     * create a new user.
    */
    public function createUser($userData)
    {
        return User::create($userData);
    }

    /**
     * update a specific user.
    */
    public function updateUser($userId, $userData)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update($userData);
            return $user;
        }
        return null;
    }

    /**
     * delete a specific user.
    */
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
