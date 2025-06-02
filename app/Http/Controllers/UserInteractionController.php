<?php

namespace App\Http\Controllers;

use App\Models\UserInteraction;
use App\Repositories\UserInteractionRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserInteractionController extends Controller
{
    protected $userInteractionRepository;
    protected $userRepository;

    public function __construct(UserInteractionRepository $userInteractionRepository, UserRepository $userRepository)
    {
        $this->userInteractionRepository = $userInteractionRepository;
        $this->userRepository = $userRepository;
    }

    public function fetchMyFriendRequests($userID) {
        return $this->userInteractionRepository->fetchMyFriendRequests($userID);
    }

    public function createFriendRequest(Request $request)
    {
        try {

            //friend request from => sender
            //friend request to => receiver
            $validatedFriendReq = $request->validate(
                [
                    'friend_request_from' => 'required|integer',
                    'friend_request_to' => 'required|integer',
                ],
                [
                    'friend_request_from.required' => 'Sender ID required.',
                    'friend_request_to.required' => 'Receiver ID is required.',
                ]
            );

            //adding the value of the curr date
            $validatedFriendReq = array_merge($validatedFriendReq, [
                'friend_request_created_at' => Carbon::now()
            ]);

            //guards
            if (!$this->userRepository->findUserByID($validatedFriendReq['friend_request_to'])) {
                return response()->json(['message' => 'User does not exist'], 404);
            }

            //send req
            $this->userInteractionRepository->createFriendRequest($validatedFriendReq);
            return response()->json(['message' => 'Friend request sent'], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function acceptFriendRequest(Request $request)
    {
        try {

            //id => friend request primary id
            $validatedFriendAcceptReq = $request->validate(
                [
                    'id' => 'required|integer',
                ],
                [
                    'id.required' => 'Sender ID required.',
                ]
            );

            if(!$this->userInteractionRepository->findFriendRequestByID($validatedFriendAcceptReq['id'])) {
                return response()->json(['message' => 'Friend request does not exist'], 404);
            }

            $this->userInteractionRepository->acceptFriendRequest($validatedFriendAcceptReq);
            return response()->json(['message' => 'Friend request accepted'], 200);

        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

     public function rejectFriendRequest(Request $request)
    {
        try {

            //id => friend request primary id
            $validatedFriendAcceptReq = $request->validate(
                [
                    'id' => 'required|integer',
                ],
                [
                    'id.required' => 'Sender ID required.',
                ]
            );

            if(!$this->userInteractionRepository->findFriendRequestByID($validatedFriendAcceptReq['id'])) {
                return response()->json(['message' => 'Friend request does not exist'], 404);
            }

            $this->userInteractionRepository->rejectFriendRequest($validatedFriendAcceptReq);
            return response()->json(['message' => 'Friend request accepted'], 200);

        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
