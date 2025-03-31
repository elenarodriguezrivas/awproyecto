document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerProductosController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            const productosContainer = document.getElementById('productos');

            if (data.length === 0) {
                productosContainer.innerHTML = '<p>No hay productos disponibles.</p>';
            } else {
                let productosHtml = '';
                data.forEach(producto => {
                    productosHtml += `
                        <div class="producto" id="producto-${producto.id}">
                            <h3>${producto.nombreProducto}</h3>
                            <p>ID: ${producto.id}</p>
                            <p>${producto.descripcionProducto}</p>
                            <p>Precio: ${producto.precio}€</p>
                            <p>Vendedor: ${producto.vendedorId}</p>
                            <p>Categoría: ${producto.categoriaProducto}</p>
                            <img src="../${producto.rutaImagen}" style="height: 200px;" />
                            ${producto.estado.toLowerCase() === 'enventa' ? `
                                <button class="btn btn-green" onclick='comprarProducto(${producto.id})'>Comprar</button>
                                <p class="mensaje-compra" id="mensaje-${producto.id}"></p>
                            ` : `
                                <div class="vendido">Vendido</div>
                            `}
                        </div>
                    `;
                });
                productosContainer.innerHTML = productosHtml;
            }
        })
        .catch(error => console.error('Error al obtener los productos:', error));
});

/**
 * Función para enviar el ID del producto al controlador de compra.
 * @param {number} productoId - El ID del producto a comprar.
 */
function comprarProducto(productoId) {
    fetch('../includes/controller/comprarProductoController.php', {
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

            // Cambiar el botón a "Vendido" si la compra fue exitosa
            const productoElemento = document.getElementById(`producto-${productoId}`);
            productoElemento.querySelector('.btn').remove(); // Eliminar el botón
            const vendidoHtml = `<div class="vendido">Vendido</div>`;
            productoElemento.insertAdjacentHTML('beforeend', vendidoHtml);
        })
        .catch(error => {
            console.error('Error al realizar la compra:', error);
            const mensajeElemento = document.getElementById(`mensaje-${productoId}`);
            mensajeElemento.textContent = 'Error al realizar la compra: ' + error.message;
            mensajeElemento.classList.add('error'); // Agregar clase para estilos
        });
}
