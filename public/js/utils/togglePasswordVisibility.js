function togglePass() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");
    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";
    icon.className = isPassword ? "bi bi-eye-slash" : "bi bi-eye";
}
