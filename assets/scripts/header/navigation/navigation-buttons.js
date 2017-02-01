{
    const menuID = document.getElementById("primaryMenu");

    if (menuID) {

        const menuListElements = menuID.getElementsByTagName('li');

        const checkForSiblings = (elements) => {
            return [].slice.call(elements)
                .filter(function (parentNode) {
                    return [].slice.call(parentNode.childNodes).some(function (node) {
                        return node.tagName === 'UL'
                    })
                });
        };

        const setupMenuElements = (elements) => {
            const insertSRT = (element) => { // SRT mean Screen Reader Text
                element = document.createElement('span');
                element.innerHTML = "expand child menu";
                element.classList.add("screen-reader-text");
                return element;
            };
            const insertButton = (element) => {
                element = document.createElement('button');
                element.classList.add("dropdown-toggle");
                element.setAttribute("aria-expanded", "false");
                return element;
            };

            elements.forEach(function (element) {
                element.insertBefore(insertButton(), element.firstElementChild.nextSibling).appendChild(insertSRT());
            });
            return elements;
        };

        const buttonToggle = (elements) => {
            elements.forEach(function (element) {
                let button = element.querySelector(".dropdown-toggle");
                button.addEventListener("click", function () {
                    this.classList.toggle("toggled-on");
                    element.classList.toggle("toggled-on");
                })
            });
            return elements;
        };

        const ariaState = (elements) => {
            elements.forEach(function (element) {
                element.addEventListener("click", function () {
                    let screenReaderText = this.querySelector('.screen-reader-text');
                    if (this.classList.contains("toggled-on")) {
                        screenReaderText.setAttribute("aria-expanded", "true");
                        screenReaderText.innerHTML = "collapse child menu";
                    }
                    else {
                        screenReaderText.setAttribute("aria-expanded", "false");
                        screenReaderText.innerHTML = "expand child menu";
                    }
                })
            });
        };

        const listElementsWithSiblings = checkForSiblings(menuListElements);

        if (listElementsWithSiblings.length > 0) {
            Promise
                .resolve(listElementsWithSiblings)
                .then(setupMenuElements)
                .then(buttonToggle)
                .then(ariaState)
                .catch();
        }
    }
}
