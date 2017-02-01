(function () {

    const visibleY = function (el) {
        var rect = el.getBoundingClientRect(), top = rect.top, height = rect.height,
            el = el.parentNode;
        do {
            rect = el.getBoundingClientRect();
            if (top <= rect.bottom === false) return false;
            // Check if the element is out of view due to a container scrolling
            if ((top + height) <= rect.top) return false;
            el = el.parentNode;
        } while (el != document.body);
        // Check its within the document viewport
        return top <= document.documentElement.clientHeight;
    };


    const visibleElements = document.querySelectorAll(".on-screen");

    window.onscroll = function () {
        for (var i = 0; i < visibleElements.length; i++) {
            var inViewPort = visibleY(visibleElements[i]);
            if (inViewPort === true) {
                visibleElements[i].classList.add("visible");
            }
            else {
                // visibleElements[i].classList.remove("visible"); // Un-comment if you want this working on scrolling up
            }

        }
    }
})();