(function () {
    const
        otherBrowsers = document.documentElement,
        chrome = document.body,
        target = document.getElementById("wrapper"),
        widthToEnable = 600,
        heightToEnable = 200;

    const getWidth = () => {
        return window.innerWidth
            || document.documentElement.clientWidth
            || document.body.clientWidth;
    };

    const onScrollClass = (screenWidth, requiredWidth) => {
        if (screenWidth > requiredWidth) {
            window.onscroll = function (event) {
                if (otherBrowsers.scrollTop > heightToEnable || chrome.scrollTop) {
                    target.classList.add("fixed-header");
                }
                else {
                    target.classList.remove("fixed-header");
                }
            };
        }
    };

    onScrollClass(getWidth(), widthToEnable);

})();