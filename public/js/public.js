const navbar = document.getElementById('mainNavbar');

if (document.body.classList.contains('homepage')) {

    window.addEventListener('scroll', function () {

        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }

    });

} else {

    // halaman selain homepage selalu solid
    navbar.classList.add('navbar-scrolled');

}
