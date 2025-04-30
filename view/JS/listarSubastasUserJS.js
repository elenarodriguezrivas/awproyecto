//listas productos en subasta del usuario, es decir, los productos que ha creado el usuariodocument.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerProductosUserController.php')
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
                        <h4>Precio: ${producto.precio}€</h4>
                        <p>${producto.descripcionProducto}</p>
                        <p>Categoría: ${producto.categoriaProducto}</p>
                        <img src="../${producto.rutaImagen}" style="height: 200px;" />
                        ${producto.estado.toLowerCase() === 'enventa' ? `
                            <button class="btn btn-red" onclick='eliminarProducto(${producto.id})'>Eliminar</button>
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
