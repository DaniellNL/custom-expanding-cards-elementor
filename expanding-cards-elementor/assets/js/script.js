jQuery(document).ready(function ($) {

    function getActiveColumns(gridElem) {
        const style = window.getComputedStyle(gridElem[0]);
        // parseInt the custom property
        let colVal = parseInt(style.getPropertyValue('--vol-cols'), 10);
        if (isNaN(colVal) || colVal < 1) colVal = 1;
        return colVal;
    }

    /* let itemsPerRow = 1;

    function getItemsPerRow() {
        let w = $(window).width();
        if (w >= 1025) {
            itemsPerRow = 4; // Desktop
        } else if (w >= 768) {
            itemsPerRow = 2; // Tablet
        } else {
            itemsPerRow = 1; // Mobile
        }
    } */

    //getItemsPerRow();
    //$(window).on('resize', getActiveColumns);

    // Helper to open a specific card
    function openCard(volunteerCard) {
        const volunteerGrid = volunteerCard.closest('.volunteer-grid');
        const volunteerDescription = volunteerGrid.find('.volunteer-description');


        // 1) Close existing description
        volunteerDescription.removeClass('active').fadeOut(200, function () {
            $(this).empty();
        });
        // Reset other cards
        volunteerGrid.find('.volunteer-card').removeClass('greyed-out active-card')
            .attr('aria-expanded', 'false')
            .blur();


        // 2) Mark the new card as active
        volunteerCard.addClass('active-card').attr('aria-expanded', 'true');
        volunteerGrid.find('.volunteer-card').not(volunteerCard).addClass('greyed-out');

        // 3) Insert the description
        let cards = volunteerGrid.children('.volunteer-card');
        let clickedIndex = cards.index(volunteerCard);

        //Get columns from CSS variable
        let columns = getActiveColumns(volunteerGrid);
        let rowStartIndex = Math.floor(clickedIndex / columns) * columns;
        let insertIndex = rowStartIndex + columns;

        let descriptionText = volunteerCard.attr('data-description') || '';

        volunteerDescription
            .html(`
                <button class="close-desc" aria-label="Close">&times;</button>
                <div>${descriptionText}</div>
            `)
            .addClass('active')
            .fadeIn(200);

        if (insertIndex >= cards.length) {
            volunteerGrid.append(volunteerDescription);
        } else {
            volunteerDescription.insertBefore(cards.eq(insertIndex));
        }

        // Close button
        volunteerDescription.find('.close-desc').on('click', function () {
            volunteerDescription.removeClass('active').fadeOut(200, function () {
                $(this).empty();
            });
            volunteerGrid.find('.volunteer-card')
                .removeClass('greyed-out active-card')
                .attr('aria-expanded', 'false')
                .blur();

            //volunteerGrid.find('.volunteer-card').trigger('mouseleave');
        });
    }

    // Click handler
    $('.volunteer-card').on('click', function () {
        let volunteerCard = $(this);
        // If already active, close
        if (volunteerCard.hasClass('active-card')) {
            // Just simulate the close button
            const volunteerGrid = volunteerCard.closest('.volunteer-grid');
            const volunteerDescription = volunteerGrid.find('.volunteer-description');
            volunteerDescription.removeClass('active').fadeOut(200, function () {
                $(this).empty();
            });
            volunteerGrid.find('.volunteer-card')
                .removeClass('greyed-out active-card')
                .attr('aria-expanded', 'false')
                .blur();

            //volunteerGrid.find('.volunteer-card').trigger('mouseleave');
            return;
        }
        // Otherwise, open
        openCard(volunteerCard);
    });

    // Keyboard support: Pressing Enter or Space = open/close
    $('.volunteer-card').on('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault(); // prevent scrolling on Space
            $(this).click();    // trigger the click handler
        }
    });
});
