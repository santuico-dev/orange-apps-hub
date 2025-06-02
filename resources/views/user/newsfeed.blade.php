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

        <script>
            let postCounter = 3;
            let likeCounts = {
                1: 0,
                2: 0
            };
            let likedPosts = new Set();
            let friendsCount = 0;

            function addFriend(friendName, buttonElement) {
                // Change button to "Added" state
                buttonElement.textContent = 'Added';
                buttonElement.classList.remove('btn-primary');
                buttonElement.classList.add('btn-success');
                buttonElement.disabled = true;

                // Add to friends list
                const friendsList = document.getElementById('friendsList');
                const friendCount = document.getElementById('friendCount');

                // Remove empty state if it exists
                if (friendsCount === 0) {
                    friendsList.innerHTML = '';
                }

                // Add friend to the list
                const friendHTML = `
                <div class="d-flex align-items-center justify-content-between mb-3 friend-item">
                    <div class="d-flex align-items-center">
                        <img src="https://via.placeholder.com/36" alt="Profile" class="profile-img me-3" style="width: 36px; height: 36px;">
                        <div>
                            <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">${friendName}</h6>
                            <small class="text-muted">Friend</small>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="removeFriend('${friendName}', this)">Remove Friend</a></li>
                            <li><a class="dropdown-item" href="#">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            `;

                friendsList.insertAdjacentHTML('beforeend', friendHTML);

                // Update friend count
                friendsCount++;
                friendCount.textContent = friendsCount;

                // Show success message
                showNotification(`You are now friends with ${friendName}!`, 'success');
            }

            function removeFriend(friendName, element) {
                // Remove from friends list
                const friendItem = element.closest('.friend-item');
                friendItem.remove();

                // Update friend count
                friendsCount--;
                const friendCount = document.getElementById('friendCount');
                friendCount.textContent = friendsCount;

                // Show empty state if no friends
                if (friendsCount === 0) {
                    const friendsList = document.getElementById('friendsList');
                    friendsList.innerHTML = `
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <p class="mb-0">No friends added yet</p>
                    </div>
                `;
                }

                // Re-enable the add button if the friend is still in suggestions
                const suggestions = document.querySelectorAll('.friend-suggestion');
                suggestions.forEach(suggestion => {
                    const name = suggestion.querySelector('h6').textContent;
                    if (name === friendName) {
                        const button = suggestion.querySelector('button');
                        button.textContent = 'Add';
                        button.classList.remove('btn-success');
                        button.classList.add('btn-primary');
                        button.disabled = false;
                    }
                });

                showNotification(`Removed ${friendName} from friends`, 'info');
            }

            function searchFriends() {
                const searchTerm = document.getElementById('friendSearch').value.toLowerCase();
                const suggestions = document.querySelectorAll('.friend-suggestion');

                suggestions.forEach(suggestion => {
                    const name = suggestion.getAttribute('data-name');
                    if (name.includes(searchTerm)) {
                        suggestion.style.display = 'flex';
                    } else {
                        suggestion.style.display = 'none';
                    }
                });
            }

            function showNotification(message, type) {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
                notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

                document.body.appendChild(notification);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 3000);
            }

            function createPost() {
                const postInput = document.getElementById('postInput');
                const content = postInput.value.trim();

                if (!content) return;

                const postsContainer = document.getElementById('postsContainer');
                const postId = postCounter++;

                const postHTML = `
                <div class="post-card mb-4" data-post-id="${postId}">
                    <div class="p-3">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/40" alt="Profile" class="profile-img me-3">
                            <div>
                                <h6 class="mb-0 fw-bold">You</h6>
                                <small class="text-muted">Just now</small>
                            </div>
                        </div>
                        <p class="mb-3">${content}</p>
                    </div>

                    <div class="post-actions px-3 py-2">
                        <div class="d-flex justify-content-around">
                            <button class="action-btn flex-fill d-flex align-items-center justify-content-center" onclick="toggleLike(${postId})">
                                <i class="far fa-thumbs-up me-2" id="like-icon-${postId}"></i>
                                <span id="like-text-${postId}">Like</span>
                            </button>
                            <button class="action-btn flex-fill d-flex align-items-center justify-content-center" onclick="toggleComments(${postId})">
                                <i class="far fa-comment me-2"></i>
                                Comment
                            </button>
                            <button class="action-btn flex-fill d-flex align-items-center justify-content-center">
                                <i class="far fa-share me-2"></i>
                                Share
                            </button>
                        </div>
                    </div>

                    <div class="px-3 py-2" id="like-count-${postId}" style="display: none;">
                        <small class="text-muted"><span id="like-number-${postId}">1</span> person likes this</small>
                    </div>

                    <div class="comments-section px-3 pb-3" id="comments-${postId}" style="display: none;">
                        <div class="comments-list mb-3" id="comments-list-${postId}"></div>
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/32" alt="Profile" class="profile-img me-2" style="width: 32px; height: 32px;">
                            <input type="text" class="form-control comment-input" placeholder="Write a comment..." id="comment-input-${postId}" onkeypress="handleCommentKeypress(event, ${postId})">
                        </div>
                    </div>
                </div>
            `;

                postsContainer.insertAdjacentHTML('afterbegin', postHTML);
                postInput.value = '';
                likeCounts[postId] = 0;
            }

            function toggleLike(postId) {
                const likeIcon = document.getElementById(`like-icon-${postId}`);
                const likeText = document.getElementById(`like-text-${postId}`);
                const likeCount = document.getElementById(`like-count-${postId}`);
                const likeNumber = document.getElementById(`like-number-${postId}`);
                const actionBtn = likeIcon.closest('.action-btn');

                if (likedPosts.has(postId)) {
                    // Unlike
                    likedPosts.delete(postId);
                    likeIcon.className = 'far fa-thumbs-up me-2';
                    likeText.textContent = 'Like';
                    actionBtn.classList.remove('liked');
                    likeCounts[postId]--;
                } else {
                    // Like
                    likedPosts.add(postId);
                    likeIcon.className = 'fas fa-thumbs-up me-2';
                    likeText.textContent = 'Liked';
                    actionBtn.classList.add('liked');
                    likeCounts[postId]++;
                }

                // Update like count display
                if (likeCounts[postId] > 0) {
                    likeNumber.textContent = likeCounts[postId];
                    likeCount.style.display = 'block';
                } else {
                    likeCount.style.display = 'none';
                }
            }

            function toggleComments(postId) {
                const commentsSection = document.getElementById(`comments-${postId}`);
                if (commentsSection.style.display === 'none') {
                    commentsSection.style.display = 'block';
                    document.getElementById(`comment-input-${postId}`).focus();
                } else {
                    commentsSection.style.display = 'none';
                }
            }

            function handleCommentKeypress(event, postId) {
                if (event.key === 'Enter') {
                    addComment(postId);
                }
            }

            function addComment(postId) {
                const commentInput = document.getElementById(`comment-input-${postId}`);
                const commentText = commentInput.value.trim();

                if (!commentText) return;

                const commentsList = document.getElementById(`comments-list-${postId}`);
                const commentHTML = `
                <div class="d-flex mb-2">
                    <img src="https://via.placeholder.com/32" alt="Profile" class="profile-img me-2" style="width: 32px; height: 32px;">
                    <div class="bg-light rounded-3 p-2 flex-grow-1">
                        <h6 class="mb-0 fw-bold" style="font-size: 0.875rem;">You</h6>
                        <p class="mb-0" style="font-size: 0.875rem;">${commentText}</p>
                    </div>
                </div>
            `;

                commentsList.insertAdjacentHTML('beforeend', commentHTML);
                commentInput.value = '';
            }

            // Handle Enter key for post creation
            document.getElementById('postInput').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    createPost();
                }
            });
        </script>

    </body>

    </html>

    </div>

@endsection
