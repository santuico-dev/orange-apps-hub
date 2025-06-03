  <head>
      <style>
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
              color: #da8309;
          }

          .menu-item i {
              width: 20px;
              margin-right: 12px;
          }

          body {
              background-color: #f8f9fa;
          }
      </style>
  </head>

  <div class="menu-options">
      <button class="menu-item" onclick="window.location.href='/newsfeed'">
          <i class="fas fa-home"></i>
          Post
      </button>
      <button class="menu-item" onclick="window.location.href='/friends'">
          <i class="fas fa-users"></i>
          Friends
      </button>
      <button class="menu-item" onclick="window.location.href='/friend-request'">
          <i class="fas fa-user-friends"></i>
          Friend Request
      </button>
      <hr class="mx-3 my-2">
      <button id="btnLogout" class="menu-item text-danger" onclick="logout()">
          <i class="fas fa-sign-out-alt"></i>
          Logout
      </button>
  </div>

  {{-- DESTROY SESSION --}}
  <script src="{{ asset('js/utils/destroy.js') }}"></script>
