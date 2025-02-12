/* script.js: Adds dynamic expand/collapse behavior for volunteer cards */

jQuery(document).ready(function ($) {
    let itemsPerRow = 1;

    // Helper to determine items per row based on current screen size
    function getItemsPerRow() {
        let w = $(window).width();
        if (w >= 900) {
            itemsPerRow = 4; // Desktop
        } else if (w >= 600) {
            itemsPerRow = 2; // Tablet
        } else {
            itemsPerRow = 1; // Mobile
        }
    }

    // Set items per row on page load
    getItemsPerRow();

    // Update items per row on window resize
    $(window).on('resize', function () {
        getItemsPerRow();
    });

    // Card click behavior
    $('.volunteer-card').on('click', function () {
        let volunteerCard = $(this);
        let volunteerGrid = volunteerCard.closest('.volunteer-grid');
        let volunteerDescription = volunteerGrid.find('.volunteer-description');
        let descriptionIsActive = volunteerDescription.hasClass('active');
        let oldActiveCard = volunteerGrid.find('.volunteer-card.active-card');

        // 1) If there is an active description, remove it (reset the old state)
        if (descriptionIsActive) {
            volunteerDescription.removeClass('active').fadeOut(200, function () {
                $(this).empty();
            });
            // Remove greyed-out & active-card from ALL cards
            volunteerGrid.find('.volunteer-card').removeClass('greyed-out active-card');
        }

        // 2) If the card clicked was the old active card, stop here (meaning user is re-clicking the same card, so we just close)
        if (oldActiveCard.is(volunteerCard)) {
            return;  // No new description to open
        }

        // 3) Set the newly clicked card as active
        volunteerCard.addClass('active-card');

        // 4) Grey out other cards (but keep them clickable now)
        volunteerGrid.find('.volunteer-card').not(volunteerCard).addClass('greyed-out');

        // 5) Insert the description box below the clicked card's row
        let cards = volunteerGrid.children('.volunteer-card');
        let clickedIndex = cards.index(volunteerCard);
        let rowStartIndex = Math.floor(clickedIndex / itemsPerRow) * itemsPerRow;
        let insertIndex = rowStartIndex + itemsPerRow;

        let descriptionText = volunteerCard.attr('data-description') || '';

        volunteerDescription
            .html(`
                <button class="close-desc">Close</button>
                <div>${descriptionText}</div>
            `)
            .addClass('active') // Mark it active
            .fadeIn(200);

        // Insert or append the description
        if (insertIndex >= cards.length) {
            volunteerGrid.append(volunteerDescription);
        } else {
            volunteerDescription.insertBefore(cards.eq(insertIndex));
        }

        // 6) Close button event
        volunteerDescription.find('.close-desc').on('click', function () {
            volunteerDescription.removeClass('active').fadeOut(200, function () {
                $(this).empty();
            });
            volunteerGrid.find('.volunteer-card').removeClass('greyed-out active-card');
        });
    });
});
