<?php

namespace App\Repositories\Interface;

interface UserInterface {

    public function fetchAllUsers();
    public function findUserByID($userID);
    public function findUserByName($name);
    public function findUserByEmail($email);
    public function findUserByPhoneNumber($phoneNumber);

    public function createUser($userData);
    public function updateUser($userID, $userData);

}
