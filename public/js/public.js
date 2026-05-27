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

/* =========================================
   FEEDBACK MODAL
========================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* RATING */

    const ratingButtons = document.querySelectorAll('.feedback-rating-item');
    const selectedRating = document.getElementById('selectedRating');

    ratingButtons.forEach(button => {

        button.addEventListener('click', () => {

            ratingButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            button.classList.add('active');

            selectedRating.value = button.dataset.rating;

        });

    });

    /* TAGS */

    const tagButtons = document.querySelectorAll('.feedback-tag');

    tagButtons.forEach(button => {

        button.addEventListener('click', () => {

            button.classList.toggle('active');

        });

    });

    /* SUBMIT */

    const feedbackForm = document.getElementById('feedbackForm');

    feedbackForm.addEventListener('submit', function (e) {

        e.preventDefault();

        /* GET TAGS */

        const activeTags = [];

        document.querySelectorAll('.feedback-tag.active')
            .forEach(tag => {

                activeTags.push(tag.innerText.trim());

            });

        document.getElementById('selectedImprovements')
            .value = JSON.stringify(activeTags);

        /* BUTTON */

        const submitBtn = document.querySelector('.feedback-submit-btn');

        submitBtn.disabled = true;

        submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm"></span>
            Mengirim...
        `;

        /* SIMULASI */

        setTimeout(() => {

            submitBtn.innerHTML = `
                <i class="bi bi-check-circle"></i>
                Feedback Terkirim
            `;

            submitBtn.style.background = '#16a34a';

            /* RESET OPTIONAL */

            feedbackForm.reset();

        }, 1200);

    });

});
