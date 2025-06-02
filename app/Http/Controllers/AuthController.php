<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        try {

            $validatedRequest = $request->validate(
                [
                    'email' => 'required|email',
                    'password' => 'required|string',
                ],
                [
                    'email.required' => 'Email is required',
                    'email.email' => 'Email must be a valid email address',
                    'password.required' => 'Password is required',
                ]
            );

            $user = $this->userRepository->findUserByEmail($validatedRequest['email']);

            //guards
            if (!$user) {
                return response()->json(['message' => 'Account does not exist'], 404);
            }

            if ($user && !Hash::check($validatedRequest['password'], $user->password)) {
                return response()->json(['message' => 'Incorrect email or password'], 401);
            }

            $token = auth()->login($user);
            return response()->json(['token' => $token], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function signup(Request $request)
    {
        try {

            $validatedRegistrationReq = $request->validate(
                [
                    'first_name' => 'required|string|max:50',
                    'last_name' => 'required|string|max:50',
                    'mobile_number' => 'required|digits:11|regex:/^09\d{9}$/',
                    'birth_date' => 'required|date|before:today',
                    'email' => 'required|email',
                    'gender' => 'required|in:male,female',
                    'password' => [
                        'required',
                        'string',
                        'min:8',              //minimum 8 characters
                        'regex:/[A-Z]/',      //must contain atleast one uppercase letter
                        'regex:/[a-z]/',      //must contain atleast one lowercase letter
                        'regex:/[0-9]/',      //must contain atleast one digit
                        'regex:/[@$!%*#?&]/', //must contain a special character
                    ],
                ],
                [
                    'first_name.required' => 'First name is required',
                    'first_name.string' => 'First name must be a valid string',
                    'last_name.required' => 'Last name is required',
                    'last_name.string' => 'Last name must be a valid string',
                    'mobile_number.required' => 'Mobile number is required',
                    'mobile_number.digits' => 'Mobile number must be 11 digits',
                    'mobile_number.regex' => 'Mobile number must start with 09 and contain only digits',
                    'birth_date.required' => 'Birthdate is required',
                    'birth_date.date' => 'Birthdate must be a valid date',
                    'birth_date.before' => 'Birthdate must be in the past',
                    'email.required' => 'Email is required',
                    'email.email' => 'Email must be a valid email address',
                    'password.required' => 'Password is required',
                    'gender.required' => 'Gender is required',
                    'password.min' => 'Password must be at least 8 characters',
                    'password.regex' => 'Password must include uppercase, lowercase, number, and special character',
                ]
            );

            $userByEmail = $this->userRepository->findUserByEmail($validatedRegistrationReq['email']);
            $userByPhoneNumber = $this->userRepository->findUserByPhoneNumber($validatedRegistrationReq['mobile_number']);

            //guards
            if($userByEmail || $userByPhoneNumber) {
                return response()->json(['message' => 'Account with the same email or mobile number already exists'], 409);
            }

            $newUser = $this->userRepository->createUser($validatedRegistrationReq);

            $token = auth()->login($newUser);
            return response()->json(['token' => $token], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
