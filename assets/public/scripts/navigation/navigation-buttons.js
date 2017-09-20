(() => {
    const menuID = document.getElementById("mainNavigation");

    if (!menuID) {
        return;
    }

    const hasChildren = menuID.querySelectorAll('.has-children');

    if (!hasChildren) {
        return;
    }


    const svgIconArrows = (button) => {

        let svg = button.querySelector('use');
        let icon = svg.getAttribute('xlink:href');
        if ('#icon-angle-down' === icon) {
            svg.setAttribute('xlink:href', '#icon-angle-up');
        }
        else {
            svg.setAttribute('xlink:href', '#icon-angle-down');
        }

    };

    Object.keys(hasChildren).forEach((listItem) => {
        let item = hasChildren[listItem];
        let button = item.querySelector('button');
        button.addEventListener('click', (e) => {
            e.preventDefault();
            item.classList.toggle('expanded');
            svgIconArrows(button);
            item.addEventListener('focusout', (e) => {
                if (!e.relatedTarget) {
                    item.classList.remove('expanded');
                }
            })
        });
    })

})();
