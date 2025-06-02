<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interface\UserInterface;

class UserRepository implements UserInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     */
    public function fetchAllUsers()
    {
        return User::all();
    }
    public function findUserByID($userID): ?User
    {
        return User::find($userID);
    }
    public function findUserByName($name): ?User
    {
        return User::where('first_name', $name)->first();
    }

    public function findUserByEmail($email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findUserByPhoneNumber($phoneNumber): ?User
    {
        return User::where('mobile_number', $phoneNumber)->first();
    }
    public function createUser($userData): ?User
    {
        return User::create($userData);
    }
    public function updateUser($userID, $userData): ?User
    {
        return null;
    }
}
