@extends('layouts.main-layout')

@section('page-title', 'Page | Friendslist')

@section('page-content')

    <head>
        <style>
            .profile-sidebar {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                position: sticky;
                top: 20px;
            }

            .profile-header {
                text-align: center;
                padding: 20px;
                border-bottom: 1px solid #e9ecef;
            }

            .profile-img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
            }

            .profile-img-large {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 10px;
            }

            .menu-item {
                display: flex;
                align-items: center;
                padding: 12px 20px;
                color: #495057;
                text-decoration: none;
                transition: all 0.3s ease;
                border: none;
                background: none;
                width: 100%;
                text-align: left;
            }

            .menu-item:hover {
                background-color: #f8f9fa;
                color: #007bff;
            }

            .menu-item i {
                width: 20px;
                margin-right: 12px;
            }

            .friends-card,
            .suggested-friends-card {
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                border: 1px solid #e4e6ea;
            }

            .friend-item {
                padding: 12px 16px;
                border-bottom: 1px solid #e4e6ea;
                transition: background-color 0.2s;
            }

            .friend-item:last-child {
                border-bottom: none;
            }

            .friend-item:hover {
                background-color: #f8f9fa;
            }

            .friend-profile-img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
            }

            .suggestion-profile-img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
            }

            .btn-add-friend {
                background-color: #1877f2;
                color: white;
                border: none;
                padding: 6px 16px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .btn-add-friend:hover {
                background-color: #166fe5;
            }

            .btn-remove {
                background-color: #e4e6ea;
                color: #1c1e21;
                border: none;
                padding: 6px 16px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .btn-remove:hover {
                background-color: #d8dadf;
            }

            .mutual-friends {
                color: #65676b;
                font-size: 13px;
                margin: 0;
            }

            .online-indicator {
                width: 12px;
                height: 12px;
                background-color: #42b883;
                border-radius: 50%;
                border: 2px solid white;
                position: absolute;
                bottom: 2px;
                right: 2px;
            }

            .friend-name {
                color: #1c1e21;
                font-weight: 600;
                margin-bottom: 2px;
            }

            .friend-status {
                color: #65676b;
                font-size: 13px;
                margin: 0;
            }

            .section-header {
                color: #1c1e21;
                font-weight: 700;
                font-size: 20px;
            }

            .see-all-link {
                color: #1877f2;
                text-decoration: none;
                font-weight: 600;
            }

            .see-all-link:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body class="bg-light">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-12">
                    <div class="row">
                        <!-- LEFT SIDEBAR -->
                        <div class="col-lg-3 col-md-4 mb-4">
                            <div class="profile-sidebar">
                                <!-- PROFILE HEADER -->
                                <div class="profile-header">
                                    <img alt="Profile" class="profile-image profile-img-large">
                                    <h5 class="profile-name mb-1 fw-bold"></h5>
                                </div>

                                <!-- LEFT SIDE MENU -->
                                @include('components.sidenav')
                            </div>
                        </div>

                        <div class="col-lg-9 col-md-8">

                            {{-- FRIENDS LIST --}}
                            <div class="friends-card mb-4">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h5 class="section-header mb-0">My Friends</h5>
                                </div>

                                <!-- FRIEND LIST CONTAINER -->
                                <div id="friendListContainer">
                                </div>
                            </div>

                            <!-- PEOPLE WHO ARE ALSO USING THIS APP -->
                            <div class="suggested-friends-card mb-4">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h5 class="section-header mb-0">People you may know</h5>
                                </div>

                                <div id="friendSuggestionContainer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- BOOTSTRAP BUNDLE --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JWT DECODE --}}
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>

    {{-- FETCHING FRIENDS --}}
    <script>
        $(document).ready(function() {
            fetchFriends();
            fetchFriendSuggestions(); //these are other users that also has their account and not yet my friend
        });

        function fetchFriends() {

            $.ajax({
                url: 'api/fetchMyFriends',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'Accept': 'application/json'
                },
                success: function(friends) {
                    $('#friendListContainer').empty();

                    //mapping the fetched data res
                    friends.forEach(function(friend) {
                        const friendsHtml = `
                            <div class="friend-item">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <img src="/storage/${friend.user_profile_image}" alt="Profile"
                                            class="friend-profile-img">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="friend-name mb-0" style="color: #000; font-family: 'Kanit', sans-serif;">${friend.user_full_name}</h6>
                                        <p class="friend-status" tyle="color: #000; font-family: 'Kanit', sans-serif;">Added on ${formatDate(friend.added_date)}</p>
                                    </div>
                                    <button class="btn-remove-friend btn btn-sm btn-outline-danger" style="font-family:Kanit, sans-serif" data-user-id="${friend.user_id}">Unfriend</button>
                                </div>
                            </div>
                        `;
                        $('#friendListContainer').append(friendsHtml);
                    });
                },
                error: function() {
                    $('#friendListContainer').html('<p class="text-danger">Failed to load posts.</p>');
                }
            });
        }

        function fetchFriendSuggestions() {
            $.ajax({
                url: 'api/fetchFriendSuggestion',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'Accept': 'application/json'
                },
                success: function(suggestions) {
                    $('#friendSuggestionContainer').empty();

                    suggestions.forEach(function(suggestion) {
                        const friendsHtml = `
                        <div class="friend-item">
                            <div class="d-flex align-items-center">
                                <img src="/storage/${suggestion.user_profile_image}" alt="Profile"
                                    class="suggestion-profile-img me-3">
                                <div class="flex-grow-1">
                                    <h6 class="friend-name mb-1">${suggestion.user_full_name}</h6>
                                    <div class="d-flex gap-2">
                                      <button class="btn-add-friend mt-1" data-name="${suggestion.user_full_name}" style="background: linear-gradient(135deg, #ffa500, #ff7f50); color: #fff; font-weight: 500; font-family: Kanit, sans-serif;">Add Friend</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        $('#friendSuggestionContainer').append(friendsHtml);
                    });
                },
                error: function() {
                    $('#friendSuggestionContainer').html('<p class="text-danger">Failed to load posts.</p>');
                }
            });
        }

        //jquery for adding friend
        $(document).on('click', '.btn-add-friend', function() {
            const fullname = $(this).data('name');

            $.ajax({
                url: 'api/createFriendRequest',
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'Accept': 'application/json'
                },
                data: {
                    receiver_full_name: fullname
                },
                success: function(suggestions) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: `Sent friend request to ${fullname}`,
                        timer: 2000,
                        showConfirmButton: false
                    }).then((result) => {
                        fetchFriendSuggestions();
                    });
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

        //jquery for removing frined
        $(document).on('click', '.btn-remove-friend', function() {

            const friendID = $(this).data('user-id');

            Swal.fire({
                icon: 'question',
                title: 'Wait!',
                text: 'Are you sure you want to remove this friend?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `api/removeFriend/${friendID}`,
                        method: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                            'Accept': 'application/json'
                        },
                        success: function(friends) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Removed from friends list.',
                                showConfirmButton: false
                            }).then((result) => {
                                fetchFriends();
                                fetchFriendSuggestions();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: `${xhr.responseJSON.message || 'An error occurred'}`,
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                fetchFriends();
                                fetchFriendSuggestions();
                            })
                        }
                    })
                }
            });


        });

        function formatDate(date) {

            //asia/manila timezone
            const d = new Date(date);
            return d.toLocaleDateString('en-PH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: 'Asia/Manila'
            });
        }
    </script>

    {{-- SESSION CHECKER --}}
    <script src="{{ asset('js/utils/session.js') }}"></script>
@endsection
