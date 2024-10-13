document.addEventListener('DOMContentLoaded', function() {
  const productosToggle = document.querySelector('.productos-toggle');
  const submenu = document.querySelector('.submenu');

  productosToggle.addEventListener('click', function(event) {
      event.preventDefault(); // Evita la recarga de la página
      submenu.classList.toggle('show'); // Alterna la clase "show" en el submenú
  });
});