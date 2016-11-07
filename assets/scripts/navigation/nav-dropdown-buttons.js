(function () {

    var menu = document.getElementById("topMenuNav");

    function checkForSiblings(element) {
        var hasSiblings = [].slice.call(element)
            .filter(function (parentNode) {
                return [].slice.call(parentNode.childNodes).some(function (node) {
                    return node.tagName === 'UL'
                })
            });
        return hasSiblings;
    }


    function createDropDownButton(element) {
        element = document.createElement('button');
        element.classList.add("dropdown-toggle");
        element.setAttribute("aria-expanded", "false");
        return element;
    }

    function createScreenReaderText(element) {
        element = document.createElement('span');
        element.innerHTML = "expand child menu";
        element.classList.add("screen-reader-text");
        return element;
    }

    function setupMenuElements(element) {
        for (var i = 0; i < element.length; i++) {
            element[i].insertBefore(createDropDownButton(), element[i].firstElementChild.nextSibling).appendChild(createScreenReaderText());
            element[i].style.color = "blue";
        }
    }

    function buttonToggle(element) {
        for (var i = 0; i < element.length; i++) {
            element[i].addEventListener("click", function () {
                this.classList.toggle("toggled-on");
                this.parentNode.classList.toggle("toggled-on");
            })
        }
    }

    function changeAriaState(element) {
        for (var i = 0; i < element.length; i++) {
            element[i].addEventListener("click", function () {
                if (this.classList.contains("toggled-on")) {
                    this.firstElementChild.setAttribute("aria-expanded", "true");
                    this.firstElementChild.innerHTML = "collapse child menu";
                }
                else {
                    this.firstElementChild.setAttribute("aria-expanded", "false");
                    this.firstElementChild.innerHTML = "expand child menu";
                }
            })
        }
    }

    setupMenuElements(checkForSiblings(menu.getElementsByTagName('li')));

    buttonToggle(menu.getElementsByClassName("dropdown-toggle"));

    changeAriaState(menu.getElementsByClassName("dropdown-toggle"));

})();