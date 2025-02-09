jQuery(document).ready(function ($) {
    let activeCard = null;

    // Function to close expanded card
    function closeExpandedCard() {
        if (activeCard) {
            activeCard.removeClass('expanded');
            activeCard = null;
        }
    }

    // Handle card click
    $('.team-card').on('click', function (e) {
        // Don't trigger if close button was clicked
        if ($(e.target).hasClass('close-expanded')) {
            return;
        }

        const clickedCard = $(this);

        // If clicking the same card that's already open, close it
        if (activeCard && activeCard[0] === clickedCard[0]) {
            closeExpandedCard();
            return;
        }

        // Close currently open card if exists
        closeExpandedCard();

        // Open clicked card
        clickedCard.addClass('expanded');
        activeCard = clickedCard;

        // Scroll expanded content into view on mobile
        if (window.innerWidth <= 768) {
            const expandedContent = clickedCard.find('.team-card-expanded');
            expandedContent[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // Close expanded card when clicking close button
    $('.close-expanded').on('click', function (e) {
        e.stopPropagation();
        closeExpandedCard();
    });

    // Close expanded card when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.team-card').length) {
            closeExpandedCard();
        }
    });

    // Handle escape key
    $(document).on('keyup', function (e) {
        if (e.key === 'Escape') {
            closeExpandedCard();
        }
    });
});