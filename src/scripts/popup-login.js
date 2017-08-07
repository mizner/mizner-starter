(function () {
    var loginForms = document.querySelectorAll("[name='loginForm']");

    for (var i = 0; i < loginForms.length; i++) {
        var username = loginForms[i].querySelectorAll(".login-username")[0];
        var userInput = username.querySelectorAll("input")[0];
        var userLabel = username.querySelectorAll("label")[0];
        userInput.setAttribute("required", "required");
        username.insertBefore(userInput, userLabel);

        var password = loginForms[i].querySelectorAll(".login-password")[0];
        var passwordInput = password.querySelectorAll("input")[0];
        var passwordLabel = password.querySelectorAll("label")[0];
        passwordInput.setAttribute("required", "required");
        password.insertBefore(passwordInput, passwordLabel);
    }
})();