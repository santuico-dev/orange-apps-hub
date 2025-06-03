@extends('layouts.main-layout')

@section('page-title', 'Page | Register')

@section('page-content')
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="bg-white shadow-lg rounded-4 overflow-hidden">
                        <div class="row g-0">

                            <!-- IMAGE -->
                            <div class="col-md-5 d-flex align-items-center justify-content-center position-relative"
                                style="background: linear-gradient(135deg, #ffa500, #ff7f50);">
                                <img src="{{ asset('images/auth-image.png') }}" alt="Login Image"
                                    class="w-100 h-100 object-fit-cover" style="border-radius: 0;">
                            </div>

                            <!-- REGISTER FORM -->
                            <div class="col-md-7 p-4">
                                <form id="signupForm">
                                    <h1 class="text-center mb-4"
                                        style="font-family: 'Kanit', sans-serif; font-weight: 700;">
                                        SIGNUP
                                    </h1>
                                    <p class="text-center mb-4 text-secondary small" style="font-family: 'Kanit', sans-serif;">
                                        Create your account to get started.
                                    </p>

                                    <!-- First Row: First Name & Last Name -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="first_name" class="form-label"
                                                style="font-family: Kanit, sans-serif">First Name</label>
                                            <input type="text" class="form-control py-2" id="first_name"
                                                placeholder="Juan">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name" class="form-label"
                                                style="font-family: Kanit, sans-serif">Last Name</label>
                                            <input type="text" class="form-control py-2" id="last_name"
                                                placeholder="Dela Cruz">
                                        </div>
                                    </div>

                                    <!-- Second Row: Gender & Birthdate -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="gender" class="form-label"
                                                style="font-family: Kanit, sans-serif">Gender</label>
                                            <select class="form-select py-2" id="gender">
                                                <option value="" selected disabled>Select gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="birthdate" class="form-label"
                                                style="font-family: Kanit, sans-serif">Birthdate</label>
                                            <input type="date" class="form-control py-2" id="birthdate">
                                        </div>
                                    </div>

                                    <!-- Third Row: Mobile & Email -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="mobile" class="form-label"
                                                style="font-family: Kanit, sans-serif">Mobile Number</label>
                                            <input type="text" class="form-control py-2" id="mobile"
                                                placeholder="09XXXXXXXXX">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label"
                                                style="font-family: Kanit, sans-serif">Email</label>
                                            <input type="email" class="form-control py-2" id="email"
                                                placeholder="sample@gmail.com">
                                        </div>
                                    </div>

                                    <!-- Password (Full Width) -->
                                    <div class="mb-4">
                                        <label for="password" class="form-label"
                                            style="font-family: Kanit, sans-serif">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password"
                                                placeholder="Enter password">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass()">
                                                <i class="bi bi-eye" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn w-100 py-2 mb-3"
                                        style="background: linear-gradient(135deg, #ffa500, #ff7f50); color: #fff; font-family: Kanit, sans-serif; font-weight: 500;">
                                        Signup
                                    </button>

                                    <hr class="my-3">

                                    <p class="text-center mb-0" style="font-family: 'Kanit', sans-serif;">
                                        Already have an account?
                                        <a href="/" class="text-decoration-none fw-semibold" style="color: #dd630a;">
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

    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SIGNUP FUNCTION --}}
    <script>
        $('#signupForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/api/signup',
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                },
                data: {
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    birth_date: $('#birthdate').val(),
                    gender: $('#gender').val(),
                    mobile_number: $('#mobile').val(),
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Signup successful!',
                        text: 'You have registered successfully.',
                        confirmButtonColor: '#ffa500'
                    }).then(() => {

                        //saving token to session storage
                        sessionStorage.setItem('token', response.token);
                        window.location.href = '/newsfeed';
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: Object.values(errors).flat().join('<br>'),
                            confirmButtonColor: '#ff7f50'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Signup failed',
                            text: xhr.responseJSON?.message || 'An error occurred.',
                            confirmButtonColor: '#ff7f50'
                        });
                    }
                }
            });
        });
    </script>

    <script src="{{ asset('js/utils/togglePasswordVisibility.js') }}"></script>
@endsection
