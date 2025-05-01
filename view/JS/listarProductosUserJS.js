document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerProductosUserController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            const productosContainer = document.getElementById('productos');
            productosContainer.classList.add('productos-grid'); // Añade la clase para aplicar estilos

            if (data.length === 0) {
                productosContainer.innerHTML = '<p>No hay productos disponibles.</p>';
            } else {
                let productosHtml = '';
                data.forEach(producto => {
                    productosHtml += `
                        <div class="producto" id="productos-${producto.id}">
                            <div class="card-body">
                                <h2 class="producto-titulo">Nombre Producto </h2>
                                <h2 class="producto-titulo-valor">${producto.nombreProducto} </h2>
                                <h3 class="producto-precio">Precio del producto</h3>
                                <h3 class="producto-precio-valor">${producto.precio}€</h3>
                                <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                                <h3 class="producto-descripcion">Descripcion:</h3>
                                <p class="producto-descripcion-valor">${producto.descripcionProducto}</p>
                                <div class="imagen-contenedor text-center"> <img src="../${producto.rutaImagen}" alt="${producto.nombreProducto}"/> </div>

                                <p>
                                <div class="producto-actions">
                                    ${producto.estado.toLowerCase() === 'enventa' ? `
                                        <div class="form-group">
                                            <a href="modificarproducto_pantalla.php?id=${producto.id}" class="btn btn-blue">Modificar</a>
                                            <button class="btn btn-red" onclick='eliminarProducto(${producto.id})'>Eliminar</button>
                                        </div>
                                        <p class="mensaje-compra" id="mensaje-${producto.id}"></p>
                                    ` : `
                                        <div class="vendido">Vendido</div>
                                    `}
                                </div>
                                </p>
                            </div>
                        </div>
                    `;
                });
                productosContainer.innerHTML = productosHtml;
            }
        })
        .catch(error => console.error('Error al obtener los productos:', error));
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
