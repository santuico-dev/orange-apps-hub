<?php

namespace App\Repositories;

use App\Models\UserInteraction;
use App\Repositories\Interface\UserInteractionInterface;

class UserInteractionRepository implements UserInteractionInterface
{

    public function findFriendRequestByID($requestID): ?UserInteraction
    {
        return UserInteraction::find($requestID);
    }

    public function fetchMyFriendRequests($userID): ?UserInteraction
    {
        return UserInteraction::where('friend_request_to', $userID)
            ->where('friend_request_status', 'pending')
            ->first();
    }

    public function fetchMyFriends($userID): ?UserInteraction
    {
        return UserInteraction::where('friend_request_to', $userID)
            ->where('friend_request_status', 'accepted')
            ->first();
    }

    public function createFriendRequest($requestData): ?UserInteraction
    {
        return UserInteraction::create($requestData);
    }

    public function removeFriend($requestData)
    {
        return null;
    }

    public function acceptFriendRequest($requestData)
    {
        return UserInteraction::where('id', $requestData['id'])->update([
            'friend_request_status' => 'accepted'
        ]);
    }

    public function rejectFriendRequest($requestData)
    {
        return UserInteraction::where('id', $requestData['id'])->update([
            'friend_request_status' => 'rejected'
        ]);
    }
}
