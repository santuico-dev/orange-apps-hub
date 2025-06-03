document.addEventListener("DOMContentLoaded", function () {
    try {
        const sessionToken = sessionStorage.getItem("token");
        if (!sessionToken) {
            window.location.href = "/";
            return;
        }

        //this decodes the jwt returned from BE and check if its expired or valid
        const decodedToken = jwt_decode(sessionToken);
        const currTime = Date.now() / 1000;

        if (decodedToken.exp < currTime) {
            sessionStorage.removeItem("token");
            window.location.href = "/";
            return;
        }

        //if there is session set the curr user information
        $(".profile-name").text(
            decodedToken.first_name + " " + decodedToken.last_name
        );
        $(".profile-image").attr(
            "src",
            `/storage/${decodedToken.user_profle_image}`
        );
        $(".post-text-input").attr(
            "placeholder",
            `What's on your mind, ${decodedToken.first_name}?`
        );
    } catch (err) {
        console.error("Invalid token");
        sessionStorage.removeItem("token");
        window.location.href = "/";
    }
});
