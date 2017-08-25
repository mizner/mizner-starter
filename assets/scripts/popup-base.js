(function () {

    var triggers = document.getElementsByClassName("popupTrigger");

    function triggerShows(arr) {
        for (var i = 0; i < arr.length; i++) {
            arr[i].addEventListener("click", function (e) {
                e.preventDefault();
                document.getElementsByClassName(this.getAttribute("name"))[0].classList.add("show");
            });
        }
        return arr;
    }

    triggerShows(triggers);

    var wrappers = document.getElementsByClassName("popupWrapper");
    var inner = document.getElementsByClassName("popupInner");

    function theSVG() {
        return "<svg class='closeIcon' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' version='1.1' x='0px' y='0px' width='20px' height='20px' viewBox='0 0 357 357' style='enable-background:new 0 0 357 357;' xml:space='preserve'> <g id='close'> <polygon points='357,35.7 321.3,0 178.5,142.8 35.7,0 0,35.7 142.8,178.5 0,321.3 35.7,357 178.5,214.2 321.3,357 357,321.3 214.2,178.5' fill='gray'></polygon> </g> </svg>";
    }

    function triggerHides(modules) {
        for (var i = 0; i < modules.length; i++) {
            modules[i].getElementsByClassName("closeButton")[0].addEventListener("click", function (e) {
                e.preventDefault();
                this.parentElement.parentElement.parentElement.classList.remove("show");
            });
        }
    }

    function addCloseButtons(elements) {
        for (var i = 0; i < elements.length; i++) {
            var btn = document.createElement("BUTTON");
            btn.innerHTML = theSVG();
            btn.classList.add("closeButton");
            var innerElement = elements[i].firstElementChild;
            innerElement.insertBefore(btn, innerElement.firstElementChild);
        }
        return elements;
    }

    function closeOnWhiteSpace(elements, inner) {
        for (var e = 0; e < elements.length; e++) {
            elements[e].addEventListener("click", function () {
                this.classList.remove("show");
            })
        }
        for (var i = 0; i < inner.length; i++) {
            inner[i].firstElementChild.addEventListener("click", function (e) {
                e.stopPropagation();
            })
        }
    }

    closeOnWhiteSpace(wrappers, inner);

    triggerHides(addCloseButtons(inner))

})();