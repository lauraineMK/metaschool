/* Script for responsive design */
document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const dropdownMenu = document.querySelector('#dropdownMenu');
    const togglerIcon = document.querySelector('.navbar-toggler-icon');
    const togglerClose = document.querySelector('.navbar-toggler-close');

    if (navbarToggler && dropdownMenu && togglerIcon && togglerClose) {
        navbarToggler.addEventListener('click', function() {
            const isMenuOpen = dropdownMenu.classList.contains('show');
            dropdownMenu.classList.toggle('show');
            togglerIcon.style.display = isMenuOpen ? 'inline' : 'none';
            togglerClose.style.display = isMenuOpen ? 'none' : 'inline';
        });

        document.addEventListener('click', function(event) {
            if (!navbarToggler.contains(event.target) && !dropdownMenu.contains(event.target)) {
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                    togglerIcon.style.display = 'inline';
                    togglerClose.style.display = 'none';
                }
            }
        });
    }
});
