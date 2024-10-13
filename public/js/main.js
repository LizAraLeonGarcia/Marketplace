<script>
    // Redirigir a la sección de inicio al cargar la página
    document.addEventListener("DOMContentLoaded", function() 
    
        if (!window.location.hash || window.location.hash !== "#inicio") {
            window.location.hash = "#inicio"
        }
    );
</script>