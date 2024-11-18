document.addEventListener('DOMContentLoaded', function() {
        actualizarTotal(); // Llamar a actualizarTotal al cargar la página para establecer el total inicial en 0 si no hay seleccionados.
    });

    function actualizarTotal() {
    let totalElemento = document.getElementById('total');
    if (!totalElemento) {
        console.error('El elemento con ID "total" no existe.');
        return;
    }

    let total = 0;
    let checkboxes = document.querySelectorAll('.checkbox-producto:checked');
    checkboxes.forEach(function(checkbox) {
        let subtotal = parseFloat(checkbox.dataset.subtotal);
        total += subtotal;
    });

    totalElemento.innerText = total.toFixed(2);
}
    // Actualizar el subtotal de cada producto
    function actualizarSubtotal(input) {
        let cantidad = parseFloat(input.value);
        let precio = parseFloat(input.dataset.precio);
        let subtotal = cantidad * precio;

        // Actualizar el subtotal en la vista
        let subtotalElemento = document.getElementById(`subtotal-${input.dataset.id}`);
        subtotalElemento.innerText = `$${subtotal.toFixed(2)}`;

        // Actualizar el data-subtotal en el checkbox para este producto
        let checkbox = document.querySelector(`.checkbox-producto[value='${input.dataset.id}']`);
        checkbox.dataset.subtotal = subtotal;

        // Actualizar el total general
        actualizarTotal();
    }
    // Eliminar el producto con AJAX sin que el checkbox interfiera
    document.querySelectorAll('.form-eliminar-producto').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas eliminar este producto del carrito?')) {
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remover el producto de la tabla
                        this.closest('tr').remove();
                        actualizarTotal(); // Actualizar el total después de eliminar
                    } else {
                        alert('No se pudo eliminar el producto. Intenta de nuevo.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });