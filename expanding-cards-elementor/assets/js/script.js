jQuery(document).ready(function ($) {
    let activeCard = null;

    function closeActiveCard() {
        if (activeCard) {
            activeCard.removeClass('active');
            const description = activeCard.find('.team-member-description');
            description.css('height', '0');
            activeCard = null;
        }
    }

    $('.team-card').on('click', function (e) {
        const clickedCard = $(this);

        // If clicking the same card that's already open, close it
        if (activeCard && activeCard[0] === clickedCard[0]) {
            closeActiveCard();
            return;
        }

        // Close any currently open card
        closeActiveCard();

        // Open clicked card
        clickedCard.addClass('active');
        const description = clickedCard.find('.team-member-description');
        const height = description[0].scrollHeight;
        description.css('height', height + 'px');
        activeCard = clickedCard;

        // Scroll into view if needed
        if (window.innerWidth <= 1024) {
            description[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    });

    // Close active card when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.team-card').length) {
            closeActiveCard();
        }
    });

    // Handle escape key
    $(document).on('keyup', function (e) {
        if (e.key === 'Escape') {
            closeActiveCard();
        }
    });

    // Reset card states on window resize
    let resizeTimer;
    $(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (activeCard) {
                const description = activeCard.find('.team-member-description');
                description.css('height', description[0].scrollHeight + 'px');
            }
        }, 250);
    });
});