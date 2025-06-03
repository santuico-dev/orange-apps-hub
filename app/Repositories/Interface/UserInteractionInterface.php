<?php

namespace App\Repositories\Interface;

interface UserInteractionInterface
{
    public function findFriendRequestByID($requestID);

    public function fetchMyFriendRequests($userID);

    public function fetchMyFriends($userID);

    public function fetchFriendSuggestion($userID);

    public function fetchPendingFriendRequests($userID);

    public function fetchSentPendingFriendRequests($userID);

    public function createFriendRequest($requestData);

    public function removeFriend($friendID, $userID);

    public function acceptFriendRequest($requestData);

    public function rejectFriendRequest($requestData);

}
