document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".expanding-card");

    cards.forEach(card => {
        card.addEventListener("click", function () {
            cards.forEach(c => {
                if (c !== card) {
                    c.classList.remove("expanded");
                }
            });

            card.classList.toggle("expanded");
        });
    });

    document.querySelectorAll(".close-btn").forEach(btn => {
        btn.addEventListener("click", function (event) {
            event.stopPropagation();
            this.closest(".expanding-card").classList.remove("expanded");
        });
    });
});