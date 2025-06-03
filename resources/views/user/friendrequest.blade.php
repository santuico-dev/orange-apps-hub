@extends('layouts.main-layout')

@section('page-title', 'Page | Friendrequest')

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
                                    <h5 class="section-header mb-0">Friend Requests</h5>
                                </div>

                                <!-- FRIEND LIST CONTAINER -->
                                <div id="pendingFriendRequestContainer">
                                </div>
                            </div>

                            <!-- PEOPLE WHO ARE ALSO USING THIS APP -->
                            <div class="suggested-friends-card mb-4">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <h5 class="section-header mb-0">Sent Pending Friend Requests</h5>
                                </div>

                                <div id="pendingSentFriendRequestContainers">
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
            fetchPendingRequest();
            fetchSentPendingFriendRequest();
        });

        function fetchPendingRequest() {

            $.ajax({
                url: 'api/fetchPendingFriendRequests',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'Accept': 'application/json'
                },
                success: function(pendingRequests) {
                    $('#pendingFriendRequestContainer').empty();

                    pendingRequests.forEach(function(friendRequest) {
                        const friendReqHtml = `
                            <div class="friend-item">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <img src="/storage/${friendRequest.user_profile_image}" alt="Profile"
                                            class="friend-profile-img">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="friend-name mb-0" style="color: #000; font-family: 'Kanit', sans-serif;">${friendRequest.user_full_name}</h6>
                                        <p class="friend-status" tyle="color: #000; font-family: 'Kanit', sans-serif;">Sent on ${formatDate(friendRequest.added_date)}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between gap-2">
                                        <button class="btn btn-sm" style="font-family:Kanit, sans-serif; background-color: #dd630a; color: #fff;" onclick="acceptFriendRequest(${friendRequest.id})">Accept</button>

                                        <button class="btn btn-sm" style="font-family:Kanit, sans-serif; background-color: #af500a; color: #fff;" onclick="rejectFriendRequest(${friendRequest.id})">Reject</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#pendingFriendRequestContainer').append(friendReqHtml);
                    });
                },
                error: function() {
                    $('#pendingFriendRequestContainer').html(
                        '<p class="text-danger">Failed to load posts.</p>');
                }
            });
        }

        //function to accept friend request
        function acceptFriendRequest(frientReqID) {
            $.ajax({
                url: `api/acceptFriendRequest`,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'Accept': 'application/json'
                },
                data: {
                    id: frientReqID
                },
                success: function() {
                    fetchPendingRequest();
                    fetchSentPendingFriendRequest();
                },
                error: function() {
                    $('#pendingFriendRequestContainer').html(
                        '<p class="text-danger">Failed to load posts.</p>');
                }
            });
        }

        //function to reject friend request
        function rejectFriendRequest(frientReqID) {
            $.ajax({
                url: `api/rejectFriendRequest`,
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'Accept': 'application/json'
                },
                data: {
                    id: frientReqID
                },
                success: function() {
                    fetchPendingRequest();
                    fetchSentPendingFriendRequest();
                },
                error: function() {
                    $('#pendingFriendRequestContainer').html(
                        '<p class="text-danger">Failed to reject friend request.</p>');
                }
            });
        }

        function fetchSentPendingFriendRequest() {
            $.ajax({
                url: 'api/fetchSentPendingFriendRequests',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'Accept': 'application/json'
                },
                success: function(pendingSentFriendRequest) {
                    $('#pendingSentFriendRequestContainers').empty();

                    pendingSentFriendRequest.forEach(function(pending) {
                        const pendingSentFriendReqHtml = `
                        <div class="friend-item">
                            <div class="d-flex align-items-center">
                                <img src="/storage/${pending.user_profile_image}" alt="Profile"
                                    class="suggestion-profile-img me-3">
                                <div class="flex-grow-1">
                                    <h6 class="friend-name mb-1">${pending.user_full_name}</h6>
                                    <p class="friend-status" tyle="color: #000; font-family: 'Kanit', sans-serif;">Requested on ${formatDate(pending.added_date)}</p>
                                </div>
                            </div>
                        </div>
                        `;
                        $('#pendingSentFriendRequestContainers').append(pendingSentFriendReqHtml);
                    });
                },
                error: function() {
                    $('#pendingSentFriendRequestContainers').html(
                        '<p class="text-danger">Failed to load posts.</p>');
                }
            });
        }

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

    {{-- DESTROY SESSION --}}
    <script src="{{ asset('js/utils/destroy.js') }}"></script>
@endsection
