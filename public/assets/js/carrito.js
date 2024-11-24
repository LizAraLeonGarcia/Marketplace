document.addEventListener('DOMContentLoaded', function () {
    const formPago = document.getElementById('form-pago');
    // Solo continua si el formulario existe
    if (!formPago) return;

    const productosSeleccionadosInput = document.getElementById('productos_seleccionados');
    const totalPrecioElement = document.getElementById('total-precio');

    function actualizarSubtotal(inputCantidad) {
        const fila = inputCantidad.closest('tr');
        const precio = parseFloat(fila.querySelector('.precio-producto-carrito').dataset.precio);
        const cantidad = parseInt(inputCantidad.value);
        const subtotal = precio * cantidad;
        fila.querySelector('.subtotal-producto').textContent = `$${subtotal.toFixed(2)}`;
    }

    function actualizarTotal() {
        const checkboxes = document.querySelectorAll('.select-product:checked');
        let total = 0;
        checkboxes.forEach(checkbox => {
            const fila = checkbox.closest('tr');
            const cantidad = parseInt(fila.querySelector('.cantidad-producto').value);
            const precio = parseFloat(fila.querySelector('.precio-producto-carrito').dataset.precio);
            total += precio * cantidad;
        });
        totalPrecioElement.textContent = total.toFixed(2);
    }

    document.querySelectorAll('.cantidad-producto').forEach(input => {
        input.addEventListener('input', function () {
            actualizarSubtotal(this);
            actualizarTotal();
        });
    });

    document.querySelectorAll('.select-product').forEach(checkbox => {
        checkbox.addEventListener('change', actualizarTotal);
    });

    formPago.addEventListener('submit', function (event) {
        const checkboxes = document.querySelectorAll('.select-product:checked');
        if (checkboxes.length === 0) {
            event.preventDefault();
            alert('Por favor, selecciona al menos un producto para pagar.');
            return;
        }
         // Rellenar el input 'productos_seleccionados' con los productos seleccionados
        const productosSeleccionados = Array.from(checkboxes).map(checkbox => {
            const fila = checkbox.closest('tr');
            const cantidad = parseInt(fila.querySelector('.cantidad-producto').value);
            return {
                id: checkbox.value,
                cantidad: cantidad
            };
        });

        productosSeleccionadosInput.value = JSON.stringify(productosSeleccionados); // Guardar datos en el campo oculto
    });

    actualizarTotal();
});
