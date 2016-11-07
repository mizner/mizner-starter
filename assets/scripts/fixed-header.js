(function () {
    var element = document.body;
    var target = document.getElementById("page-container");
    var widthToEnable = 600;
    var heightToEnable = 200;

    function getWidth() {
        return window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;
    }

    function onScrollClass(screenWidth, requiredWidth) {
        if (screenWidth > requiredWidth) {
            window.onscroll = function (event) {
                if (element.scrollTop > heightToEnable) {
                    target.classList.add("fixedHeader");
                }
                else {
                    target.classList.remove("fixedHeader");
                }
            };
        }
    }

    onScrollClass(getWidth(), widthToEnable);
    
})();