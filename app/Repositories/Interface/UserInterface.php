<?php

namespace App\Repositories\Interface;

interface UserInterface {

    public function fetchAllUsers();
    public function fetchUserByID($userID);
    public function fetchUserByName($name);

    public function createUser($userData);
    public function updateUser($userID, $userData);

}
