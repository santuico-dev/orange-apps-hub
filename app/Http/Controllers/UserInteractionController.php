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

    public function fetchMyFriendRequests()
    {
        return $this->userInteractionRepository->fetchMyFriendRequests(auth()->user()->id);
    }

    public function fetchFriendSuggestion()
    {
        return $this->userInteractionRepository->fetchFriendSuggestion(auth()->user()->id);
    }

    public function fetchMyFriends()
    {
        return $this->userInteractionRepository->fetchMyFriends(auth()->user()->id);
    }

    public function fetchUserByName($name) {
        return $this->userRepository->findUserByName($name);
    }

    public function fetchPendingFriendRequests() {
        return $this->userInteractionRepository->fetchPendingFriendRequests(auth()->user()->id);
    }

    public function fetchSentPendingFriendRequests() {
        return $this->userInteractionRepository->fetchSentPendingFriendRequests(auth()->user()->id);
    }

    public function createFriendRequest(Request $request)
    {
        try {

            //friend request from => sender
            //friend request to => receiver
            $validatedFriendReq = $request->validate(
                [
                    'receiver_id' => 'required|integer',
                    'receiver_full_name' => 'required|string',
                ],
                [
                    'receiver_id.required' => 'Receiver ID is required.',
                    'receiver_full_name.required' => 'Receiver full name is required.',
                    'receiver_full_name.string' => 'Receiver full name must be a string.',
                ]
            );

            //guards
            $isUserExisting = $this->userRepository->findUserByID($validatedFriendReq['receiver_id']);
            $isSameUser = $validatedFriendReq['receiver_id'] == auth()->user()->id;

            if (!$isUserExisting) {
                return response()->json(['message' => 'User does not exist'], 404);
            }

            if($isSameUser) {
                return response()->json(['message' => 'You cannot send a friend request to yourself'], 400);
            }
            //adding the value of the curr date
            $validatedFriendReq = array_merge($validatedFriendReq, [
                'friend_request_created_at' => Carbon::now()->toDateString(),
                'friend_request_from' => auth()->user()->id,
                'friend_request_to' => $validatedFriendReq['receiver_id'],
            ]);

            //send req
            $sendFriendReqRes = $this->userInteractionRepository->createFriendRequest($validatedFriendReq);
            return response()->json(['message' => $sendFriendReqRes], 200);

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
                    'id.required' => 'Friend Request ID is required.',
                ]
            );

            if (!$this->userInteractionRepository->findFriendRequestByID($validatedFriendAcceptReq['id'])) {
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
                    'id.required' => 'Friend Request ID is required.',
                ]
            );

            if (!$this->userInteractionRepository->findFriendRequestByID($validatedFriendAcceptReq['id'])) {
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

    public function removeFriend($friendID)
    {
        try {

            //guards
            if(!$friendID) {
                return response()->json(['message' => 'Invalid Friend ID'], 422);
            }

            if(!$this->userRepository->findUserByID($friendID)) {
                return response()->json(['message' => 'User does not exist'], 404);
            }

           $removeFriendRes = $this->userInteractionRepository->removeFriend($friendID, auth()->user()->id);

           if($removeFriendRes) {
                return response()->json(['message' => 'Friend removed'], 200);
           }else {
                return response()->json(['message' => 'Friend does not exist'], 404);
           }
        }catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
