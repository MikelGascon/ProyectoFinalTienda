document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll(".rating-stars span");
    const ratingInput = document.getElementById("rating-value");

    stars.forEach(star => {
        star.addEventListener("click", () => {
            const value = parseInt(star.dataset.value);
            ratingInput.value = value;
            pintarEstrellas(value);
        });

        star.addEventListener("mouseover", () => {
            pintarEstrellas(star.dataset.value);
        });

        star.addEventListener("mouseleave", () => {
            pintarEstrellas(ratingInput.value);
        });
    });

    function pintarEstrellas(value) {
        stars.forEach(s => {
            s.classList.toggle("text-warning", s.dataset.value <= value);
            s.classList.toggle("text-muted", s.dataset.value > value);
        });
    }
});
