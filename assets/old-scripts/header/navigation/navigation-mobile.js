{
    // -------------------------------
    // Mobile Menu Navigation Actions
    // -------------------------------
    const menuButton = document.getElementById('main_navigation-button');

    if (menuButton) {
        const topMenuNav = document.getElementById('primaryMenu');
        const menuIcon = menuButton.querySelector(".main_navigation-button-icon");

        menuButton.addEventListener('click', function () {
            menuIcon.classList.toggle("open");
            topMenuNav.classList.toggle('toggled');
            let aria = this.getAttribute('aria-expanded');
            if (aria === 'false') {
                topMenuNav.setAttribute('aria-expanded', 'true');
                menuButton.setAttribute('aria-expanded', 'true');
            }
            else {
                topMenuNav.setAttribute('aria-expanded', 'false');
                menuButton.setAttribute('aria-expanded', 'false');
            }
        })
    }
}