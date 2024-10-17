document.addEventListener('DOMContentLoaded', function() {
  const submenu = document.querySelector('.submenu'); // Asegúrate de que este elemento existe en tu HTML
  const links = document.querySelectorAll('.nav-links a');
  const sections = document.querySelectorAll('section');

  // Toggle para el submenú de productos (si es necesario)
  const productosToggle = document.querySelector('.productos-toggle');
  if (productosToggle) {
      productosToggle.addEventListener('click', function(event) {
          event.preventDefault(); // Evita la recarga de la página
          submenu.classList.toggle('show'); // Alterna la clase "show" en el submenú
      });
  }

  // Maneja el clic en los enlaces de navegación
  links.forEach(link => {
      link.addEventListener('click', function(event) {
          event.preventDefault();
          const targetId = this.getAttribute('href').substring(1); // Obtiene el id de destino
          
          // Oculta todas las secciones
          sections.forEach(section => {
              section.classList.remove('active'); // Elimina la clase "active"
              section.style.display = 'none'; // Opcional: oculta la sección
          });
          
          // Muestra la sección objetivo
          const targetSection = document.getElementById(targetId);
          if (targetSection) {
              targetSection.classList.add('active'); // Agrega la clase "active" para mostrar la sección
              targetSection.style.display = 'block'; // Muestra la sección
          }
      });
  });

  // Muestra la sección inicial (opcional)
  const inicioSection = document.getElementById('inicio');
  if (inicioSection) {
      inicioSection.classList.add('active');
      inicioSection.style.display = 'block'; // Muestra la sección de inicio
  }
});
