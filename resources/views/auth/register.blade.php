@extends('layouts.main-layout')

@section('page-title', 'Page | Register')

@section('page-content')
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="bg-white shadow-lg rounded-4 overflow-hidden">
                        <div class="row g-0">

                            <!-- IMAGE -->
                            <div class="col-md-6 d-flex align-items-center justify-content-center position-relative"
                                style="background: linear-gradient(135deg, #ffa500, #ff7f50);">
                                <img src="{{ asset('images/auth-image.png') }}" alt="Login Image"
                                    class="w-100 h-100 object-fit-cover" style="border-radius: 0;">
                            </div>

                            <!-- REGISTER FORM -->
                            <div class="col-md-6 p-5">
                                <form>
                                    <h1 class="text-center mb-4"
                                        style="font-family: 'Kanit', sans-serif; font-weight: 700;">
                                        SIGNUP
                                    </h1>

                                    <div class="mb-3">
                                        <label for="email" class="form-label" style="font-family: 'Kanit', sans-serif;">
                                            Email
                                        </label>
                                        <input type="email" class="form-control py-2" id="email"
                                            placeholder="sample@gmail.com" style="border-radius: 8px;">
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label" style="font-family: 'Kanit', sans-serif;">
                                            Password
                                        </label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password"
                                                placeholder="Enter password">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                                onclick="togglePass()">
                                                <i class="bi bi-eye" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn w-100 py-2 mb-4"
                                        style="font-family: 'Kanit', sans-serif; border-radius: 8px; font-weight: 500; background: linear-gradient(135deg, #ffa500, #ff7f50); color: #fff;">
                                        Signup
                                    </button>

                                    <hr class="my-4">

                                    <p class="text-center mb-0" style="font-family: 'Kanit', sans-serif;">
                                        Already have an account?
                                        <a href="/login" class="text-decoration-none fw-semibold" style="color: #dd630a;">
                                            Login
                                        </a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/utils/togglePasswordVisibility.js') }}"></script>
@endsection
