(function () {
    var container = document.getElementsByClassName("site-menu");

    function preventClick(link) {
        link.addEventListener("click", function (e) {
            e.preventDefault();
        })
    }

    function getAllLinks(menu) {
        var links = menu.querySelectorAll("a");
        for (var i = 0, len = links.length; i < len; i++) {
            var theLink = links[i].attributes.href.value;
            if (theLink === "#") {
                preventClick(links[i]);
            }
        }
    }

    function checkAllMenus(menus) {
        for (var i = 0; i < menus.length; i++) {
            getAllLinks(menus[i]);
        }
    }

    checkAllMenus(container);

})();