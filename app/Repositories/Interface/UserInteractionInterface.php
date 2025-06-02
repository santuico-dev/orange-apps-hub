<?php

namespace App\Repositories\Interface;

interface UserInteractionInterface
{
    public function findFriendRequestByID($requestID);

    public function fetchMyFriendRequests($userID);

    public function fetchMyFriends($userID);

    public function createFriendRequest($requestData);

    public function removeFriend($requestData);

    public function acceptFriendRequest($requestData);

    public function rejectFriendRequest($requestData);

}
