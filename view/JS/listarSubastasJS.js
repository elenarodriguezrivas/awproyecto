//listar productos en subasta en general
document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerSubastasController.php')
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
                    const fechaActual = new Date(Date.now()); // Obtener la fecha actual precisa
                    const fechaFinSubasta = new Date(subasta.fechaFin);

                    subastasHtml += `
                        <div class="subasta" id="subasta-${subasta.id}">
                            <h3>id Producto: ${subasta.idProducto}</h3>
                            <h4>precio: ${subasta.precio}€</h4>
                            <p>id Comprador: ${subasta.idComprador}</p>
                            <p>Fecha fin de subasta: ${subasta.fechaFin}</p>
                            ${fechaFinSubasta > fechaActual ? `
                                <button class="btn btn-green" onclick='pujarProducto(${subasta.idProducto})'>Añadir puja</button>
                                <p class="mensaje-compra" id="mensaje-${subasta.idProducto}"></p>
                            ` : `
                                <div class="subastado">Subasta terminada</div>
                            `}
                        </div>
                    `;
                });
                subastasContainer.innerHTML = subastasHtml;
            }
        })
        .catch(error => console.error('Error al obtener los productos:', error));
});

/**
 * Función para enviar el ID del producto al controlador de compra.
 * @param {number} productoId - El ID del producto a comprar.
 */
function pujarProducto(productoId) {
    fetch('../includes/controller/pujarProductoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: productoId }), // Enviar solo el ID del producto como JSON
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.text();
        })
        .then(data => {
            // Mostrar el mensaje del servidor debajo del botón
            const mensajeElemento = document.getElementById(`mensaje-${productoId}`);
            mensajeElemento.textContent = data;
            mensajeElemento.classList.add('success'); // Agregar clase para estilos

            // Cambiar el botón a "Puja hecha" si la puja fue exitosa
            const productoElemento = document.getElementById(`producto-${productoId}`);
            productoElemento.querySelector('.btn').remove(); // Eliminar el botón
            const vendidoHtml = `<div class="pujado">Puja Hecha</div>`;
            productoElemento.insertAdjacentHTML('beforeend', vendidoHtml);
        })
        .catch(error => {
            console.error('Error al realizar la puja:', error);
            const mensajeElemento = document.getElementById(`mensaje-${productoId}`);
            mensajeElemento.textContent = 'Error al realizar la puja: ' + error.message;
            mensajeElemento.classList.add('error'); // Agregar clase para estilos
        });
}
