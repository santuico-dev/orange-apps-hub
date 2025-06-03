document.addEventListener('DOMContentLoaded', function () {
    const logoutButton = document.getElementById('btnLogout');
    logoutButton.addEventListener('click', function () {
        sessionStorage.removeItem('token');
        window.location.href = '/';
    });
});
