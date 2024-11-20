document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('btn-toggle'); // Asegúrate de que este ID esté en tu HTML
    const menuLateral = document.getElementById('menu-lateral'); // Este ID debe coincidir con el del menú lateral

    // Validar existencia de elementos
    if (toggleButton && menuLateral) {
        toggleButton.addEventListener('click', () => {
            console.log('Botón toggle presionado');
            menuLateral.classList.toggle('menu-visible'); // Alterna la visibilidad del menú
        });
    } else {
        console.error('El menú lateral o el botón toggle no se encontraron. Revisa los IDs.');
    }
});
