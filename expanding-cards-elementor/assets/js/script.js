jQuery(document).ready(function ($) {
    let activeCard = null;

    function closeActiveCard() {
        if (activeCard) {
            activeCard.removeClass('active');
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
        activeCard = clickedCard;

        // Scroll into view if needed
        if (window.innerWidth <= 1023) {
            const description = clickedCard.find('.team-member-description');
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
});