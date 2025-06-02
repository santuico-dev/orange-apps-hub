@extends('layouts.main-layout')

@section('page-title', 'Page | Login')

@section('page-content')

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="bg-white shadow-lg rounded-4 overflow-hidden">
                        <div class="row g-0">

                            <!-- FORM -->
                            <div class="col-md-6 p-5">
                                <form id="login-form">
                                    @csrf

                                    <h1 class="text-center mb-4" style="font-family: 'Kanit', sans-serif; font-weight: 700;">
                                        LOGIN
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
                                        Login
                                    </button>

                                    <hr class="my-4">

                                    <p class="text-center mb-0" style="font-family: 'Kanit', sans-serif;">
                                        No account yet?
                                        <a href="/signup" class="text-decoration-none fw-semibold" style="color: #dd630a;">
                                            Register
                                        </a>
                                    </p>
                                </form>
                            </div>

                            <!-- IMAGE -->
                            <div class="col-md-6 d-flex align-items-center justify-content-center position-relative"
                                style="background: linear-gradient(135deg, #ffa500, #ff7f50);">
                                <img src="{{ asset('images/auth-image.png') }}" alt="Login Image"
                                    class="w-100 h-100 object-fit-cover" style="border-radius: 0;">
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

    {{-- LOGIN FUNCTION --}}
    <script>
        $('#login-form').on('submit', function(e) {
            e.preventDefault();

            const email = $('#email').val();
            const password = $('#password').val();

            $.ajax({
                url: 'api/login',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {

                    //saving to local storage
                    localStorage.setItem('token', response.token);
                    window.location.href = '/newsfeed';
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.message;
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: `${Object.values(errors).join('\n')}`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: `${xhr.responseJSON.message || 'An error occurred'}`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }
            });
        });
    </script>

    <script src="{{ asset('js/utils/togglePasswordVisibility.js') }}"></script>

@endsection
