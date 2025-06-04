<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserInteraction;
use App\Repositories\Interface\UserInteractionInterface;
use Illuminate\Support\Facades\DB;

class UserInteractionRepository implements UserInteractionInterface
{

    public function findFriendRequestByID($requestID): ?UserInteraction
    {
        return UserInteraction::find($requestID);
    }

    public function fetchMyFriendRequests($userID)
    {
        return UserInteraction::join('users', 'users.id', '=', 'friend_request.friend_request_from')
            ->select(
                'friend_request.id',
                'users.user_profile_image as user_profile_image',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'friend_request.friend_request_created_at as added_date'
            )
            ->where('friend_request_to', $userID)
            ->where('friend_request_status', 'pending')
            ->limit(5) //temp
            ->get();
    }

    public function fetchMyFriends($userID)
    {
        $sentFriendships = UserInteraction::where('friend_request_from', $userID)
            ->where('friend_request_status', 'accepted')
            ->join('users', 'users.id', '=', 'friend_request.friend_request_to')
            ->select(
                'users.id as user_id',
                'users.user_profile_image',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'friend_request.friend_request_created_at as added_date'
            );

        $receivedFriendships = UserInteraction::where('friend_request_to', $userID)
            ->where('friend_request_status', 'accepted')
            ->join('users', 'users.id', '=', 'friend_request.friend_request_from')
            ->select(
                'users.id as user_id',
                'users.user_profile_image',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'friend_request.friend_request_created_at as added_date'

            );

        //merging the results of two queries
        $allFriends = $sentFriendships->union($receivedFriendships)
            ->limit(5)  //temp
            ->get();

        return $allFriends;
    }

    public function fetchFriendSuggestion($userID)
    {
        //id of the friend request that the curr user sent <= this is any status of the req
        $sentIDs = UserInteraction::where('friend_request_from', $userID)
            ->pluck('friend_request_to');

        //ids where the curr user recieved request and it was accepted
        $receivedAcceptedIDs = UserInteraction::where('friend_request_to', $userID)
            ->where('friend_request_status', 'accepted')
            ->pluck('friend_request_from');

        //ids where the user sent to other user and got accepted
        $sentAcceptedIDs = UserInteraction::where('friend_request_from', $userID)
            ->where('friend_request_status', 'accepted')
            ->pluck('friend_request_to');

        //merging all
        $excludedIDs = $sentIDs
            ->merge($receivedAcceptedIDs)
            ->merge($sentAcceptedIDs)
            ->unique();

        return User::where('id', '!=', $userID)
            ->whereNotIn('id', $excludedIDs)
            ->select(
                'id as user_id',
                'user_profile_image',
                DB::raw("CONCAT(first_name, ' ', last_name) as user_full_name")
            )
            ->get();
    }

    public function fetchPendingFriendRequests($userID)
    {
        return UserInteraction::join('users', 'users.id', '=', 'friend_request.friend_request_from')
            ->select(
                'friend_request.id',
                'users.user_profile_image as user_profile_image',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'friend_request.friend_request_created_at as added_date'
            )
            ->where('friend_request_to', $userID)
            ->where('friend_request_status', 'pending')
            ->limit(5) //temp
            ->get();
    }

    public function fetchSentPendingFriendRequests($userID)
    {
        return UserInteraction::join('users', 'users.id', '=', 'friend_request.friend_request_to')
            ->select(
                'friend_request.id',
                'users.user_profile_image as user_profile_image',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_full_name"),
                'friend_request.friend_request_created_at as added_date'
            )
            ->where('friend_request_from', $userID)
            ->where('friend_request_status', 'pending')
            ->limit(5) //temp
            ->get();
    }

    public function createFriendRequest($requestData)
    {
        UserInteraction::create($requestData);
        return 'Friend request sent successfully';
    }

    public function removeFriend($friendID, $userID)
    {

        //friend request sent by the curr user
        UserInteraction::where('friend_request_from', $userID)
            ->where('friend_request_to', $friendID)
            ->where('friend_request_status', 'accepted')
            ->delete();

        //friend reuqest sent by other user to the curr user
        UserInteraction::where('friend_request_from', $friendID)
            ->where('friend_request_to', $userID)
            ->where('friend_request_status', 'accepted')
            ->delete();
    }

    public function acceptFriendRequest($requestData)
    {
        return UserInteraction::where('id', $requestData['id'])->update([
            'friend_request_status' => 'accepted'
        ]);
    }

    public function rejectFriendRequest($requestData)
    {
        //I delete the request to reset it back to 'Add Friend' state again
        return UserInteraction::where('id', $requestData['id'])->delete();
    }
}
