(function () {
    var element = document.body;
    var target = document.getElementById("mobile-menu-button");
    var widthToDisable = 767;

    function getWidth() {
        return window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;
    }

    function onScrollClass(screenWidth, requiredWidth) {
        if (screenWidth < requiredWidth) {
            var lastScrollPosition = 0;
            window.onscroll = function () {
                var newScrollPosition = window.scrollY;

                if (newScrollPosition < lastScrollPosition) {
                    //upward - code here
                    // console.log("up");
                    target.classList.remove("hide-on-scroll");
                } else {
                    //downward - code here
                    target.classList.add("hide-on-scroll");
                    // console.log("down");
                }
                lastScrollPosition = newScrollPosition;
            };
        }
    }

    onScrollClass(getWidth(), widthToDisable);

})();