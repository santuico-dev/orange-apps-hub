@extends('layouts.main-layout')

@section('page-title', 'Page | Newsfeed')

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

            .create-post {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .post-card {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .post-input {
                border: none;
                background-color: #f8f9fa;
                border-radius: 25px;
                padding: 15px 20px;
                cursor: pointer;
                font-size: 16px;
            }

            .post-input:focus {
                box-shadow: none;
                border: 2px solid #007bff;
                background-color: #fff;
            }

            .post-modal {
                background-color: rgba(0, 0, 0, 0.8);
            }

            .modal-content {
                background-color: #fff;
                color: #000;
                border: none;
                border-radius: 8px;
            }

            .modal-header {
                border-bottom: 1px solid #4e4f50;
            }

            .modal-footer {
                border-top: 1px solid #4e4f50;
            }

            .post-textarea {
                background-color: transparent;
                border: none;
                color: white;
                font-size: 24px;
                resize: none;
                min-height: 120px;
            }

            .post-textarea:focus {
                outline: none;
                box-shadow: none;
                background-color: transparent;
                color: white;
            }

            .post-textarea::placeholder {
                color: #b0b3b8;
                font-size: 24px;
            }

            .upload-zone {
                border: 2px dashed #4e4f50;
                border-radius: 8px;
                padding: 40px;
                text-align: center;
                background-color: #e9ecef;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .upload-zone:hover {
                border-color: #de7e17;
                background-color: #e4e4e5;
            }

            .upload-zone.dragover {
                border-color: #1877f2;
                background-color: #1877f2;
                opacity: 0.1;
            }

            .privacy-selector {
                background-color: #4e4f50;
                color: white;
                border: none;
                border-radius: 6px;
                padding: 8px 12px;
                font-size: 14px;
            }

            .post-options-bar {
                background-color: #242526;
                border-radius: 8px;
                padding: 12px;
                margin-top: 15px;
            }

            .option-btn {
                background: none;
                border: none;
                color: #b0b3b8;
                font-size: 24px;
                padding: 8px 12px;
                border-radius: 6px;
                transition: background-color 0.3s ease;
            }

            .option-btn:hover {
                background-color: #e9ecef;
            }

            .btn-post {
                background-color: #1877f2;
                color: white;
                border: none;
                border-radius: 6px;
                padding: 8px 24px;
                font-weight: 600;
            }

            .btn-post:hover {
                background-color: #166fe5;
            }

            .btn-post:disabled {
                background-color: #4e4f50;
                color: #8a8d91;
            }

            .preview-image {
                max-width: 100%;
                max-height: 300px;
                border-radius: 8px;
                object-fit: cover;
            }

            .action-btn {
                border: none;
                background: none;
                padding: 8px 12px;
                border-radius: 5px;
                transition: background-color 0.3s ease;
            }

            .action-btn:hover {
                background-color: #f8f9fa;
            }

            .post-actions {
                border-top: 1px solid #e9ecef;
            }

            body {
                background-color: #f8f9fa;
            }
        </style>
    </head>

    <body class="bg-light">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-12">
                    <div class="row">
                        <!-- Left Sidebar - Profile -->
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

                        <!-- Main Content (Newsfeed) - Center Right -->
                        <div class="col-lg-9 col-md-8">
                            <div class="create-post p-3 mb-4">
                                <input type="text" class="post-text-input form-control post-input w-100"
                                    placeholder="What's on your mind, John?" id="postInputTrigger" readonly
                                    onclick="openPostModal()">
                            </div>
                            <!-- Posts Container -->
                            <div id="postsContainer">
                                <div class="post-card mb-4" data-post-id="1">
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
                                        <div id="commentSectionContainer">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL --}}
        <div class="modal fade post-modal" id="postModal" tabindex="-1" aria-labelledby="postModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postModalLabel" style="font-family: Kanit, sans-serif">Create post</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- User Info -->
                        <div class="d-flex align-items-center mb-3">
                            <img alt="Profile" class="profile-image profile-img me-3">
                            <div>
                                <h6 class="profile-name mb-0 fw-bold"></h6>
                            </div>
                        </div>

                        <!-- Text Input -->
                        <textarea class="post-text-input form-control post-textarea" placeholder="What's on your mind, John?" id="postTextarea"
                            style="color: #000; font-family: Poppins, sans-serif; font=weight: 300"></textarea>

                        <!-- Preview Container -->
                        <div id="previewContainer" class="mt-3" style="display: none;">
                            <div class="position-relative">
                                <!-- this will be replaced dynamically with either image or video -->
                                <div id="mediaPreview"></div>
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                    onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Upload Zone -->
                        <div id="uploadZone" class="upload-zone mt-3"
                            onclick="document.getElementById('fileInput').click()">
                            <div>
                                <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Upload photos/videos</h5>
                                <p class="text-muted">or drag and drop</p>
                            </div>
                            <input type="file" id="fileInput" accept="image/*,video/*" style="display: none;"
                                onchange="handleFileSelect(this)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-post w-100"
                            style="background: linear-gradient(135deg, #ffa500, #ff7f50); color: #fff; font-family: Kanit, sans-serif; font-weight: 500;"
                            id="btnPost" disabled>
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- JQUERY --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        {{-- BOOTSTRAP BUNDLE --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        {{-- JWT DECODE --}}
        <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>

        {{-- ALERT --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- POST HANDLER --}}
        <script>
            let selectedFile = null;

            //function to open the post modal
            function openPostModal() {
                const modal = new bootstrap.Modal(document.getElementById('postModal'));
                modal.show();

                //focus on textarea when modal opens so you can type straight away
                setTimeout(() => {
                    document.getElementById('postTextarea').focus();
                }, 500);
            }

            //funtion to handle file selection
            function handleFileSelect(input) {

                //getting the uploaded file
                const file = input.files[0];
                if (!file) return;

                selectedFile = file;
                const reader = new FileReader();

                //function that will be trigerred when the file is uploaded
                reader.onload = function(e) {

                    //getting the preview container & media preview element
                    const previewContainer = document.getElementById('previewContainer');
                    const mediaPreview = document.getElementById('mediaPreview');

                    mediaPreview.innerHTML = '';

                    //checking if the uploaded file is an image or video
                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Image Preview';
                        img.className = 'preview-image';
                        mediaPreview.appendChild(img);
                    } else if (file.type.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.controls = true;
                        video.className = 'preview-image';
                        mediaPreview.appendChild(video);
                    } else {
                        //prompting the user that his/her uploaded file is unsupoorted
                        Swal.fire({
                            icon: 'warning',
                            title: 'Unsupported file type',
                            text: 'Please upload an image or video.',
                            confirmButtonColor: '#ff7f50'
                        });
                        return;
                    }

                    previewContainer.style.display = 'block';
                    document.getElementById('uploadZone').style.display = 'none';
                    checkPostButton();
                };

                reader.readAsDataURL(file);
            }

            //function to remove the uploaded image
            function removeImage() {
                selectedFile = null;
                document.getElementById('previewContainer').style.display = 'none';
                document.getElementById('uploadZone').style.display = 'block';
                document.getElementById('fileInput').value = '';
                checkPostButton();
            }

            //function to enable the button when textarea is not empty or it has an image
            function checkPostButton() {
                const textarea = document.getElementById('postTextarea');
                const submitBtn = document.getElementById('btnPost');

                if (textarea.value.trim() || selectedFile) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }

            //post
            $('#btnPost').on('click', function(e) {

                e.preventDefault();

                const textarea = document.getElementById('postTextarea');
                const postText = textarea.value.trim();

                //doing this to avoid Illegal Invocation error since we are directly passing in object of the file
                const postFormData = new FormData();
                postFormData.append('post_content', postText);

                if (selectedFile) {
                    postFormData.append('media', selectedFile);
                }

                if (postText || selectedFile) {
                    $.ajax({
                        url: '/api/createPost',
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + sessionStorage.getItem('token')
                        },
                        data: postFormData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Post successful!',
                                text: 'You have registered successfully.',
                                confirmButtonColor: '#ffa500'
                            }).then((result) => {
                                //fetch the post again so that it is updated
                                fetchPosts();

                                //clear the post input && remove the image once uploaded
                                textarea.value = '';
                                removeImage();

                                //close modal once post is submitted
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'postModal'));
                                modal.hide();
                            })
                        },
                        error: function(xhr) {
                            textarea.value = '';
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.message;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: Object.values(errors).flat().join('<br>'),
                                    confirmButtonColor: '#ff7f50'
                                });
                            }
                        }
                    })
                }


            })

            //dropzone
            const uploadZone = document.getElementById('uploadZone');

            uploadZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const fileInput = document.getElementById('fileInput');
                    fileInput.files = files;
                    handleFileSelect(fileInput);
                }
            });

            //this handles the enabling and disabling of the post button
            document.getElementById('postTextarea').addEventListener('input', checkPostButton);
        </script>

        {{-- SESSION CHECKER --}}
        <script src="{{ asset('js/utils/session.js') }}"></script>

        {{-- FETCHING OF POST --}}
        <script>
            $(document).ready(function() {
                fetchPosts();
            });

            function fetchPosts() {
                $.ajax({
                    url: 'api/fetchAllPost',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
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

                                            <!-- Post Content determining if the post contains https which makes a link -->

                                            <p>${parseLinks(post.post_content) || ""}</p>

                                           <!-- Post Media where it determines if its image or video by using media_type -->
                                          <div class="d-flex align-items-center justify-content-center">
                                            ${post.media_type === 'image' && post.post_media_path
                                                ? `<img src="/storage/${post.post_media_path}" alt="Post Media" class="img-fluid rounded mb-3" style="height: 450px; object-fit: cover;" />`
                                                : post.media_type === 'video' && post.post_media_path
                                                ? `<video controls class="img-fluid rounded mb-3" style="height: 450px; object-fit: cover;">
                                                                                                    <source src="/storage/${post.post_media_path}" type="video/mp4">
                                                                                                    Your browser does not support the video tag.
                                                                                            </video>`
                                                : ''
                                            }
                                        </div>
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
                                                    <i class="fas fa-share-alt me-2"></i> Share
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Like Count -->
                                        <div class="px-3 py-2" id="like-count-${post.id}" style="display: none;">
                                            <small class="text-muted"><span id="like-number-${post.id}">${post.post_like_count}</span> people like this</small>
                                        </div>

                                        <!-- Comments Section -->
                                        <div class="comments-section px-3 pb-3" id="comments-${post.id}" style="display: none;">
                                                <div class="comments-list mb-3" id="comments-list-${post.id}">
                                                    <!-- Existing comments will be appended here -->
                                                </div>
                                                <div class="d-flex align-items-start gap-2">
                                                    <img src="/storage/${post.user_profile_image}" alt="Profile" class="profile-img" style="width: 32px; height: 32px;">
                                                    <div class="flex-grow-1">
                                                        <textarea class="form-control comment-input" placeholder="Write a comment..." rows="2" id="comment-input-${post.id}"></textarea>
                                                        <div class="d-flex justify-content-end mt-2">
                                                            <button class="btn btn-sm" onclick="submitComment(${post.id})" style="background: linear-gradient(135deg, #ffa500, #ff7f50); color: #fff; font-family: Kanit, sans-serif; font-weight: 500;">Post Comment</button>
                                                        </div>
                                                    </div>
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

            //function to parse links that is included with the post
            function parseLinks(text) {
                const urlRegex = /(https?:\/\/[^\s]+)/g;
                return text.replace(urlRegex, url => `<a href="${url}" target="_blank">${url}</a>`);
            }

            //this is just for interval based on how long the post has been created
            function timeAgo(dateString) {
                const date = new Date(dateString + 'Z');
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

            //function to fetch comment
            function fetchComments(postId) {
                $.ajax({
                    url: `/api/fetchPostCommentsByPostID/${postId}`,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                        'Accept': 'application/json'
                    },
                    success: function(comments) {
                        const commentContainer = $(`#comments-list-${postId}`);
                        commentContainer.empty();

                        if (comments.length === 0) {
                            commentContainer.html('<p class="text-muted">No comments yet.</p>');
                            return;
                        }

                        comments.forEach(function(comment) {
                            const commentHtml = `
                            <div class="d-flex align-items-start mb-3">
                                <img src="/storage/${comment.user_profile_image}" alt="Profile" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover;">
                                <div class="bg-light p-2 rounded" style="max-width: 100%;">
                                    <div class="fw-semibold" style="font-size: 0.95rem;">${comment.user_full_name}</div>
                                    <div style="font-size: 0.875rem;">${comment.comment_content}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">${timeAgo(comment.comment_date)}</div>
                                </div>
                            </div>
                        `;
                            commentContainer.append(commentHtml);
                        });
                    },
                    error: function() {
                        $(`#comments-list-${postId}`).html('<p class="text-danger">Failed to load comments.</p>');
                    }
                });
            }

            //function for toggling the visibility of the comment section
            function toggleComments(postId) {
                const commentSection = document.getElementById(`comments-${postId}`);
                commentSection.style.display = commentSection.style.display === 'none' ? 'block' : 'none';

                fetchComments(postId);
            }

            //function to submit comment
            function submitComment(postId) {

                const input = document.getElementById(`comment-input-${postId}`);
                const content = input.value.trim(); //getting the value of the comment

                //no content found
                if (content === '') return;

                $.ajax({
                    url: `/api/createPostComment`,
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                        'Accept': 'application/json'
                    },
                    data: {
                        post_id: postId,
                        comment_content: content
                    },
                    success: function(response) {

                        //load comments again after commenting
                        fetchComments(postId);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to post comment, try again.',
                            text: 'You have registered successfully.',
                            confirmButtonColor: '#ffa500'
                        })
                    }
                });
            }
        </script>
    </body>
    </div>

@endsection
