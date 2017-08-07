(function () {

    function objectFit() {
        var objFitContainers = document.querySelectorAll(".object-fit-fix");
        if (!Modernizr.objectfit) {
            console.log(!Modernizr.objectfit);
            for (var i = 0; i < objFitContainers.length; i++) {
                var image = objFitContainers[i].getElementsByTagName("img")[0];
                objFitContainers[i].style.background = "url('" + image.src + "') center center no-repeat";
                objFitContainers[i].classList.add("transparent_child");
            }
        }
    }

    objectFit();

    // Jetpack Gallery Support
    function jetpackObjectFit() {
        var galleryItems = document.querySelectorAll(".tiled-gallery-item");

        if (galleryItems) {
            if (!Modernizr.objectfit) {
                for (var i = 0; i < galleryItems.length; i++) {
                    var image = galleryItems[i].getElementsByTagName("img")[0];
                    console.log(image.src);
                    galleryItems[i].style.background = "url('" + image.src + "') center center no-repeat";
                    galleryItems[i].classList.add("transparent_child");
                }
            }
        }
    }

    jetpackObjectFit();

})();