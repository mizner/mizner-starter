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


    // -------------------------------
    // Click Handling
    // -------------------------------

    function removeActive(array) {
        array.forEach(function (item) {
            item.classList.remove("active");
        })
    }

    var formContainers = document.querySelectorAll(".option-wrapper");

    var loginLink = document.querySelector("#loginLink");
    var loginForm = document.querySelector("[form-link='loginLink']");
    var registerLink = document.querySelector("#registerLink");
    var registerForm = document.querySelector("[form-link='registerLink']");


    var loginTab = document.querySelector("[button-value='sign-in']");
    var registerTab = document.querySelector("[button-value='register']");

    loginLink.addEventListener("click", function (event) {
        loginTab.classList.add("active");
        removeActive(formContainers);
        loginForm.classList.add("active");
    });

    registerLink.addEventListener("click", function (event) {
        registerTab.classList.add("active");
        removeActive(formContainers);
        registerForm.classList.add("active");
    });


    // -------------------------------
    // Tab Handling
    // -------------------------------


    loginTab.addEventListener("click", function (event) {
        removeActive(formContainers);
        registerTab.classList.remove("active");
        this.classList.add("active");
        loginForm.classList.add("active");
    });
    registerTab.addEventListener("click", function (event) {
        removeActive(formContainers);
        loginTab.classList.remove("active");
        this.classList.add("active");
        registerForm.classList.add("active");
    });

    // Error
    var error = document.querySelector(".gform_validation_error");
    if (error) {
        registerLink.click();
    }


})();