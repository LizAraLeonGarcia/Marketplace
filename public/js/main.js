document.addEventListener('DOMContentLoaded', function() {
  const productosToggle = document.querySelector('.productos-toggle');
  const submenu = document.querySelector('.submenu');

  productosToggle.addEventListener('click', function(event) {
      event.preventDefault(); // Evita la recarga de la página
      submenu.classList.toggle('show'); // Alterna la clase "show" en el submenú
  });
});

document.querySelectorAll('nav a').forEach(anchor => {
  anchor.addEventListener('click', function(event) {
      event.preventDefault();
      const targetId = this.getAttribute('href').substring(1); // Obtiene el id de destino
      
      document.querySelectorAll('section').forEach(section => {
          section.style.display = 'none'; // Oculta todas las secciones
      });
      
      document.getElementById(targetId).style.display = 'block'; // Muestra la sección objetivo
  });
});
