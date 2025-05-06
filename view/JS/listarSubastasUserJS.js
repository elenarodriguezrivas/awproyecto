document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerSubastasUserController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las subastas');
            }
            return response.json();
        })
        .then(data => {
            const subastasContainer = document.getElementById('subastas');

            if (data.length === 0) {
                subastasContainer.innerHTML = '<p>No hay subastas disponibles.</p>';
            } else {
                let subastasHtml = '';
                data.forEach(subasta => {
                    subastasHtml += `
                        <div class="subasta" id="subasta-${subasta.id}">
                            <div class="subasta-info">
                                <h2>${subasta.nombreSubasta}</h2>
                                <h3>Precio actual de la subasta: ${subasta.precio_actual}€</h3>
                                <h4>Precio original de la subasta: ${subasta.precio_original}€</h4>
                                <p>${subasta.descripcionSubasta}</p>
                                <p><img src="../${subasta.rutaImagen}" alt="${subasta.nombreSubasta}" /></p>
                                <p>
                                <div class="subasta-actions">
                                    ${subasta.estado.toLowerCase() === 'en_subasta' ? `
                                        <div class="form-group">
                                            <a href="modificarsubasta_pantalla.php?id=${subasta.id}" class="btn btn-blue">Modificar</a>
                                            <button class="btn btn-red" onclick='eliminarProducto(${subasta.id})'>Eliminar</button>
                                        </div>
                                        <p class="mensaje-compra" id="mensaje-${subasta.id}"></p>
                                    ` : `
                                        <div class="vendido">Vendido</div>
                                    `}
                                </div>
                                </p>
                            </div>
                        </div>
                    `;
                });
                subastasContainer.innerHTML = subastasHtml;
            }
        })
        .catch((error) => {
            console.error('Error al obtener las subastas:', error);
            window.location.href = 'login_pantalla.php';
        });
});

/**
 * Función para eliminar un producto.
 * @param {number} productoId - El ID del producto a eliminar.
 */
function eliminarProducto(productoId) {
    if (!confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        return; // Si el usuario cancela, no se realiza ninguna acción
    }

    fetch('../includes/controller/eliminarProductoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: productoId }), // Enviar el ID del producto como JSON
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.text();
        })
        .then(data => {
            alert(data); // Mostrar el mensaje del servidor
            // Eliminar el producto del DOM
            const productoElemento = document.getElementById(`producto-${productoId}`);
            if (productoElemento) {
                productoElemento.remove();
            }
        })
        .catch(error => {
            console.error('Error al eliminar el producto:', error);
            alert('Error al eliminar el producto: ' + error.message);
        });
}
