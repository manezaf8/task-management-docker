function toggleForms() {
    var loginForm = document.getElementById("loginForm");
    var createUserForm = document.getElementById("createUserForm");

    if (loginForm.style.display === "none") {
        loginForm.style.display = "none";
        createUserForm.style.display = "block";
    } else {
        loginForm.style.display = "block";
        createUserForm.style.display = "none";
    }
}