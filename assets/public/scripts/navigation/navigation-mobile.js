/**
 * Mobile Menu Navigation Actions
 */
(() => {
    const menuButton = document.getElementById('mainNavigationButton');
    if (!menuButton) {
        return;
    }

    const menuButtonClickEvent = () => {

        const menuNav = document.getElementById('mainNavigation');

        menuButton.addEventListener('click', () => {
            let aria = menuNav.getAttribute('aria-expanded');
            if (aria === 'false') {
                menuNav.setAttribute('aria-expanded', 'true');
                menuButton.setAttribute('aria-expanded', 'true');
            }
            else {
                menuNav.setAttribute('aria-expanded', 'false');
                menuButton.setAttribute('aria-expanded', 'false');
            }
        })
    };

    if (menuButton) {

        menuButtonClickEvent(menuButton);

    }
})();