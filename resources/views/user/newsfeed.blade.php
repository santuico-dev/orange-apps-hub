@extends('layouts.main-layout')

@section('page-title', 'Page | Newsfeed')

@section('page-content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Social Media Feed</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            .post-card {
                border: 1px solid #e3e6ea;
                border-radius: 12px;
                background: white;
            }

            .profile-img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
            }

            .post-actions {
                border-top: 1px solid #e3e6ea;
                border-bottom: 1px solid #e3e6ea;
            }

            .action-btn {
                border: none;
                background: none;
                padding: 12px;
                border-radius: 8px;
                transition: background-color 0.2s;
            }

            .action-btn:hover {
                background-color: #f0f2f5;
            }

            .action-btn.liked {
                color: #1877f2;
            }

            .comment-input {
                border: none;
                background-color: #f0f2f5;
                border-radius: 20px;
                padding: 8px 16px;
            }

            .comment-input:focus {
                outline: none;
                box-shadow: none;
            }

            .create-post {
                border: 1px solid #e3e6ea;
                border-radius: 12px;
                background: white;
            }

            .post-input {
                border: none;
                background-color: #f0f2f5;
                border-radius: 20px;
                padding: 12px 16px;
            }

            .post-input:focus {
                outline: none;
                box-shadow: none;
            }
        </style>
    </head>

    <body class="bg-light">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-12">
                    <div class="row">
                        <!-- Main Content (Newsfeed) -->
                        <div class="col-lg-7 col-md-8">

                            <!-- Create Post Section -->
                            <div class="create-post p-3 mb-4">
                                <div class="d-flex mb-3">
                                    <img src="https://via.placeholder.com/40" alt="Profile" class="profile-img me-3">
                                    <input type="text" class="form-control post-input" placeholder="What's on your mind?"
                                        id="postInput">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary px-4" onclick="createPost()">Post</button>
                                </div>
                            </div>

                            <!-- Posts Container -->
                            <div id="postsContainer">
                                <!-- Sample Post 1 -->
                                <div class="post-card mb-4" data-post-id="1">
                                    <div class="p-3">
                                        <!-- Post Header -->
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="https://via.placeholder.com/40" alt="Profile"
                                                class="profile-img me-3">
                                            <div>
                                                <h6 class="mb-0 fw-bold">...</h6>
                                                <small class="text-muted">...</small>
                                            </div>
                                        </div>

                                        <!-- Post Content -->
                                        <p class="mb-3">Loading....</p>
                                    </div>

                                    <!-- Post Actions -->
                                    <div class="post-actions px-3 py-2">
                                        <div class="d-flex justify-content-around">
                                            <button
                                                class="action-btn flex-fill d-flex align-items-center justify-content-center"
                                                onclick="toggleLike(1)">
                                                <i class="far fa-thumbs-up me-2" id="like-icon-1"></i>
                                                <span id="like-text-1">Like</span>
                                            </button>
                                            <button
                                                class="action-btn flex-fill d-flex align-items-center justify-content-center"
                                                onclick="toggleComments(1)">
                                                <i class="far fa-comment me-2"></i>
                                                Comment
                                            </button>
                                            <button
                                                class="action-btn flex-fill d-flex align-items-center justify-content-center">
                                                <i class="far fa-share me-2"></i>
                                                Share
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Like Count -->
                                    <div class="px-3 py-2" id="like-count-1" style="display: none;">
                                        <small class="text-muted"><span id="like-number-1">1</span> person likes
                                            this</small>
                                    </div>

                                    <!-- Comments Section -->
                                    <div class="comments-section px-3 pb-3" id="comments-1" style="display: none;">
                                        <div class="comments-list mb-3" id="comments-list-1">
                                            <!-- Comments will be added here -->
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/32" alt="Profile"
                                                class="profile-img me-2" style="width: 32px; height: 32px;">
                                            <input type="text" class="form-control comment-input"
                                                placeholder="Write a comment..." id="comment-input-1"
                                                onkeypress="handleCommentKeypress(event, 1)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Sidebar - Friends Section -->
                        <div class="col-lg-5 col-md-4">
                            <div class="sticky-top" style="top: 20px;">

                                <!-- Add Friends Section -->
                                <div class="bg-white rounded-3 shadow-sm p-3 mb-4" style="border: 1px solid #e3e6ea;">
                                    <h5 class="fw-bold mb-3">Add Friends</h5>

                                    <!-- Search Friends -->
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Search for friends..."
                                            id="friendSearch" onkeyup="searchFriends()">
                                    </div>

                                    <!-- Friend Suggestions -->
                                    <div id="friendSuggestions">
                                        <div class="d-flex align-items-center justify-content-between mb-3 friend-suggestion"
                                            data-name="alice johnson">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Profile"
                                                    class="profile-img me-3">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Alice Johnson</h6>
                                                    <small class="text-muted">3 mutual friends</small>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="addFriend('Alice Johnson', this)">Add</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mb-3 friend-suggestion"
                                            data-name="mike wilson">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Profile"
                                                    class="profile-img me-3">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Mike Wilson</h6>
                                                    <small class="text-muted">1 mutual friend</small>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="addFriend('Mike Wilson', this)">Add</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mb-3 friend-suggestion"
                                            data-name="sarah davis">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Profile"
                                                    class="profile-img me-3">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Sarah Davis</h6>
                                                    <small class="text-muted">5 mutual friends</small>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="addFriend('Sarah Davis', this)">Add</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mb-3 friend-suggestion"
                                            data-name="tom anderson">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Profile"
                                                    class="profile-img me-3">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Tom Anderson</h6>
                                                    <small class="text-muted">2 mutual friends</small>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="addFriend('Tom Anderson', this)">Add</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mb-3 friend-suggestion"
                                            data-name="emma brown">
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/40" alt="Profile"
                                                    class="profile-img me-3">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">Emma Brown</h6>
                                                    <small class="text-muted">4 mutual friends</small>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="addFriend('Emma Brown', this)">Add</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Friends List Section -->
                                <div class="bg-white rounded-3 shadow-sm p-3" style="border: 1px solid #e3e6ea;">
                                    <h5 class="fw-bold mb-3">Your Friends <span class="badge bg-secondary"
                                            id="friendCount">0</span></h5>

                                    <div id="friendsList">
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <p class="mb-0">No friends added yet</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- JQUERY --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        {{-- FETCHIBBG --}}
        <script>
            $(document).ready(function() {
                fetchPosts();

                function fetchPosts() {
                    $.ajax({
                        url: 'api/fetchAllPost',
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + localStorage.getItem('token'),
                            'Accept': 'application/json'
                        },
                        success: function(posts) {
                            $('#postsContainer').empty();

                            posts.forEach(function(post) {
                                const postHtml = `
                     <div class="post-card mb-4" data-post-id="${post.id}">
                        <div class="p-3">
                            <!-- Post Header -->
                            <div class="d-flex align-items-center mb-3">
                                <img src="${post.user_profile_image ? '/storage/' + post.user_profile_image : 'https://via.placeholder.com/40'}" alt="Profile" class="profile-img me-3">
                                <div>
                                    <h6 class="mb-0 fw-bold">${post.user_full_name}</h6>
                                    <small class="text-muted">${timeAgo(post.post_created_at)}</small>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <p class="mb-3">${post.post_content || ''}</p>

                            <!-- Post Media -->
                            ${post.media_type === 'image' && post.post_media_path
                                ? `<img src="/storage/${post.post_media_path}" alt="Post Media" class="img-fluid rounded mb-3" />`
                                : ''
                            }
                        </div>

                        <!-- Post Actions -->
                        <div class="post-actions px-3 py-2">
                            <div class="d-flex justify-content-around">
                                <button class="action-btn flex-fill d-flex align-items-center justify-content-center" onclick="toggleLike(${post.id})">
                                    <i class="far fa-thumbs-up me-2" id="like-icon-${post.id}"></i>
                                    <span id="like-text-${post.id}">Like</span>
                                </button>
                                <button class="action-btn flex-fill d-flex align-items-center justify-content-center" onclick="toggleComments(${post.id})">
                                    <i class="far fa-comment me-2"></i> Comment
                                </button>
                                <button class="action-btn flex-fill d-flex align-items-center justify-content-center">
                                    <i class="far fa-share me-2"></i> Share
                                </button>
                            </div>
                        </div>

                        <!-- Like Count -->
                        <div class="px-3 py-2" id="like-count-${post.id}" style="display: none;">
                            <small class="text-muted"><span id="like-number-${post.id}">${post.post_like_count}</span> people like this</small>
                        </div>

                        <!-- Comments Section -->
                        <div class="comments-section px-3 pb-3" id="comments-${post.id}" style="display: none;">
                            <div class="comments-list mb-3" id="comments-list-${post.id}"></div>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/32" alt="Profile" class="profile-img me-2" style="width: 32px; height: 32px;">
                                <input type="text" class="form-control comment-input" placeholder="Write a comment..." id="comment-input-${post.id}" onkeypress="handleCommentKeypress(event, ${post.id})">
                            </div>
                        </div>
                    </div>

                    `;
                                $('#postsContainer').append(postHtml);
                            });
                        },
                        error: function() {
                            $('#postsContainer').html('<p class="text-danger">Failed to load posts.</p>');
                        }
                    });
                }

                function timeAgo(dateString) {
                    const date = new Date(dateString);
                    const seconds = Math.floor((new Date() - date) / 1000);
                    let interval = Math.floor(seconds / 31536000);
                    if (interval >= 1) return interval + " year" + (interval > 1 ? "s" : "") + " ago";
                    interval = Math.floor(seconds / 2592000);
                    if (interval >= 1) return interval + " month" + (interval > 1 ? "s" : "") + " ago";
                    interval = Math.floor(seconds / 86400);
                    if (interval >= 1) return interval + " day" + (interval > 1 ? "s" : "") + " ago";
                    interval = Math.floor(seconds / 3600);
                    if (interval >= 1) return interval + " hour" + (interval > 1 ? "s" : "") + " ago";
                    interval = Math.floor(seconds / 60);
                    if (interval >= 1) return interval + " minute" + (interval > 1 ? "s" : "") + " ago";
                    return Math.floor(seconds) + " seconds ago";
                }
            });
        </script>
    </body>

    </html>

    </div>

@endsection
