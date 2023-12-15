<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
class UserRepository
{
    /**
     * All users record.
    */
    public function getAllUsers($sortField, $sortOrder = 'asc', $search = [])
    {
        $perPage = 5; // Adjust the number of users per page as needed

        $query = User::orderBy($sortField, $sortOrder);

        // Exclude the currently logged-in user
        $query->where('id', '!=', Auth::id());

        // Apply search if provided
        if (!empty($search)) {
            $searchTerms = explode(' ', $search);
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $value) {
                    $q->orWhere('user_name', 'like', '%' . $value . '%')
                        ->orWhere('first_name', 'like', '%' . $value . '%')
                        ->orWhere('last_name', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->orWhere('phone', 'like', '%' . $value . '%')
                        ->orWhere('dob', 'like', '%' . $value . '%');
                }
            });
        }

        return $query->paginate($perPage)->fragment('users');
    }


    /**
     * Details of a specific user.
    */
    public function getUserById($userId)
    {
        return User::find($userId);
    }

    /**
     * List of all users.
    */
    public function getAllRoles()
    {
        return Role::orderBy('id', 'desc')->get();
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
