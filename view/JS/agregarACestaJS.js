// Función para añadir un producto a la cesta
function agregarACesta(productoId) {
fetch('../includes/controller/agregarProductoCestaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            productoId: productoId
        })
    })
    .then(response => response.json())
    .then(data => {
        // Mostrar mensaje al usuario
        const mensajeElement = document.getElementById(`mensaje-${productoId}`);
        
        if (data.success) {
            // Caso de éxito
            mensajeElement.className = 'mensaje-compra success';
            mensajeElement.textContent = data.message;
            
            // Ocultar el mensaje después de 3 segundos
            setTimeout(function() {
                mensajeElement.textContent = '';
                mensajeElement.className = 'mensaje-compra';
            }, 3000);
        } else {
            // Caso de error
            mensajeElement.className = 'mensaje-compra error';
            mensajeElement.textContent = data.message;
            
            // Si necesitamos redireccionar (por ejemplo, a la página de login)
            if (data.redirect) {
                setTimeout(function() {
                    window.location.href = data.redirect;
                }, 2000);
            }
        }
    })
    .catch(error => {
        console.error('Error al añadir el producto a la cesta:', error);
        // Mostrar mensaje de error
        const mensajeElement = document.getElementById(`mensaje-${productoId}`);
        mensajeElement.className = 'mensaje-compra error';
        mensajeElement.textContent = 'Error al comunicarse con el servidor, por favor intenta de nuevo más tarde.';
    });
}