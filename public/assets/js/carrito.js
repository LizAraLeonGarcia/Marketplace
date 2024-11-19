document.addEventListener('DOMContentLoaded', () => {
    const formPago = document.getElementById('form-pago');
    const productosSeleccionadosInput = document.getElementById('productos_seleccionados');
    const totalPrecioElement = document.getElementById('total-precio');

    // Actualizar el subtotal de un producto específico
    function actualizarSubtotal(inputCantidad) {
        const fila = inputCantidad.closest('tr'); // Fila correspondiente
        const precio = parseFloat(fila.querySelector('.precio-producto-carrito').dataset.precio); // Leer precio
        const cantidad = parseInt(inputCantidad.value); // Leer cantidad
        const subtotal = precio * cantidad; // Calcular subtotal

        // Actualizar el subtotal en la fila
        fila.querySelector('.subtotal-producto').textContent = `$${subtotal.toFixed(2)}`;
    }

    // Actualizar el total sumando los subtotales de los productos seleccionados
    function actualizarTotal() {
        const checkboxes = document.querySelectorAll('.select-product:checked'); // Productos seleccionados
        let total = 0;

        checkboxes.forEach(checkbox => {
            const fila = checkbox.closest('tr');
            const cantidad = parseInt(fila.querySelector('.cantidad-producto').value);
            const precio = parseFloat(fila.querySelector('.precio-producto-carrito').dataset.precio);
            total += precio * cantidad;
        });

        // Actualizar el total en el elemento correspondiente
        totalPrecioElement.textContent = total.toFixed(2);
    }

    // Escuchar cambios en el campo de cantidad para actualizar el subtotal
    document.querySelectorAll('.cantidad-producto').forEach(input => {
        input.addEventListener('input', function () {
            actualizarSubtotal(this); // Actualizar subtotal de este producto
            actualizarTotal(); // Opcional: actualizar el total dinámicamente
        });
    });

    // Escuchar cambios en los checkboxes para calcular el total
    document.querySelectorAll('.select-product').forEach(checkbox => {
        checkbox.addEventListener('change', actualizarTotal);
    });

    // Manejar envío del formulario
    formPago.addEventListener('submit', function (event) {
        const checkboxes = document.querySelectorAll('.select-product:checked');
        if (checkboxes.length === 0) {
            event.preventDefault();
            alert('Por favor, selecciona al menos un producto para pagar.');
            return;
        }

        const productosSeleccionados = Array.from(checkboxes).map(checkbox => {
            const fila = checkbox.closest('tr');
            const cantidad = parseInt(fila.querySelector('.cantidad-producto').value);
            return {
                id: checkbox.value,
                cantidad: cantidad
            };
        });

        productosSeleccionadosInput.value = JSON.stringify(productosSeleccionados);
    });

    // Inicializar el total al cargar la página
    actualizarTotal();
});
