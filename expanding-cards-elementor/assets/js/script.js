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
        let alreadyOpen = volunteerDescription.hasClass('active') && volunteerCard.hasClass('active-card');

        // Remove existing open states
        $('.volunteer-card').removeClass('active-card greyed-out');
        volunteerDescription.removeClass('active').empty().hide();

        // If clicking the already open card, just close
        if (alreadyOpen) {
            return;
        }

        // Mark the clicked card as active
        volunteerCard.addClass('active-card');

        // Grey out other cards
        volunteerGrid.find('.volunteer-card').not(volunteerCard).addClass('greyed-out');

        // Insert the description box below the row
        let cards = volunteerGrid.children('.volunteer-card');
        let clickedIndex = cards.index(volunteerCard);
        let rowStartIndex = Math.floor(clickedIndex / itemsPerRow) * itemsPerRow;
        let insertIndex = rowStartIndex + itemsPerRow;

        let descriptionText = volunteerCard.attr('data-description') || '';

        volunteerDescription
            .html(`\n                <button class=\"close-desc\">Close</button>\n                <div>${descriptionText}</div>\n            `)
            .addClass('active')
            .fadeIn(200);

        // Insert the description
        if (insertIndex >= cards.length) {
            volunteerGrid.append(volunteerDescription);
        } else {
            volunteerDescription.insertBefore(cards.eq(insertIndex));
        }

        // Close button event
        volunteerDescription.find('.close-desc').on('click', function () {
            volunteerDescription.removeClass('active').fadeOut(200, function () {
                $(this).empty();
            });
            volunteerGrid.find('.volunteer-card').removeClass('greyed-out active-card');
        });
    });
});
