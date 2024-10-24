function showpassword() {
    var password = document.getElementById("password");

    if (password.attributes["type"].value != "text") {
        password.attributes["type"].value = "text";
        document.getElementById("pass-eye").classList.replace("fa-eye", "fa-eye-slash");
    }
    else {
        password.attributes["type"].value = "password"
        document.getElementById("pass-eye").classList.replace("fa-eye-slash", "fa-eye");
    }
}