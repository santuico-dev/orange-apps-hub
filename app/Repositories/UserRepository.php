<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interface\UserInterface;

class UserRepository implements UserInterface
{
    public function fetchAllUsers(): ?User
    {
        return null;
    }
    public function fetchUserByID($userID): ?User
    {
        return null;
    }
    public function fetchUserByName($name): ?User
    {
        return null;
    }

    public function createUser($userData): ?User
    {
        return null;
    }
    public function updateUser($userID, $userData): ?User
    {
        return null;
    }
}
