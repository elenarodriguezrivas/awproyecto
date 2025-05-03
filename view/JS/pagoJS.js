document.addEventListener('DOMContentLoaded', function() {
    const formPago = document.getElementById('formPago');
    const totalCompra = document.getElementById('totalCompra').value;

    formPago.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar campos
        const metodoPago = document.querySelector('input[name="metodoPago"]:checked').value;
        const numeroTarjeta = document.getElementById('numeroTarjeta').value;
        const fechaExpiracion = document.getElementById('fechaExpiracion').value;
        const cvv = document.getElementById('cvv').value;

        if (metodoPago === 'tarjeta' && (!numeroTarjeta || !fechaExpiracion || !cvv)) {
            alert('Por favor complete todos los campos de la tarjeta');
            return;
        }

        // Simular envío a RedSys (en producción sería una API real)
        fetch('procesar_pago.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                metodoPago,
                totalCompra,
                productos: Array.from(document.querySelectorAll('#resumen-productos .producto')).map(p => ({
                    id: p.dataset.id,
                    precio: p.dataset.precio
                }))
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exito) {
                // Mostrar modal de éxito
                const modal = new bootstrap.Modal(document.getElementById('modalConfirmacion'));
                modal.show();
                
                // Vaciar la cesta
                fetch('vaciar_cesta.php', { method: 'POST' });
            } else {
                alert('Error en el pago: ' + data.mensaje);
            }
        });
    });
});