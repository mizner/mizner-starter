(function () {
    var button = document.querySelector(".sitewide-cta-button");
    var container = document.querySelector(".sitewide-cta-wrapper");
    button.addEventListener("click", function (e) {
        if (container.classList.contains("hide")) {
            container.classList.remove("hide");
            container.classList.add("show");
        }
        else {
            container.classList.remove("show");
            container.classList.add("hide");
        }
    })
})();