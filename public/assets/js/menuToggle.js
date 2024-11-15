document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".custom-menu");

    if (toggleButton) {
        toggleButton.addEventListener("click", function() {
            console.log("Botón clickeado");
            menu.classList.toggle("menu-visible");
            console.log(menu.classList); // Verifica si la clase 'menu-visible' está correctamente aplicada
        });
    }
});
