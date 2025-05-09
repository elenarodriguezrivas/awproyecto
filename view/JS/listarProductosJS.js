document.addEventListener("DOMContentLoaded", function () {
    const selectorCategoria = document.getElementById("selectorCategoria");

    // Cargar las categorías desde el servidor
    fetch('../includes/controller/obtenerCategoriasController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las categorías');
            }
            return response.json();
        })
        .then(data => {
            // Vaciar el selector de categorías y añadir las nuevas opciones
            selectorCategoria.innerHTML = '<option value="">Todas las categorías</option>';

            data.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.nombreCategoria;
                option.textContent = categoria.nombreCategoria;
                selectorCategoria.appendChild(option);
            });
        })
        .catch(error => console.error('Error al obtener las categorías:', error));

    let categoria = selectorCategoria.value;
    console.log(categoria);
    
    fetch('../includes/controller/obtenerProductosController.php', {
        method: 'POST',
        body: categoria
    })
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
                        <div class="producto card mb-4" id="producto-${producto.id}">
                            <div class="card-body">
                                <h2 class="card-title">${producto.nombreProducto}</h2>
                                <h3 class="card-subtitle mb-2 text-muted">Precio del producto: ${producto.precio}€</h3>
                                <p class="card-text">${producto.descripcionProducto}</p>
                                <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                                <img src="../${producto.rutaImagen}" class="img-fluid mb-3" style="height: 200px;" />
                                <div class="acciones-producto text-center">
                                    ${producto.estado.toLowerCase() === 'enventa' ? `
                                        <button class="btn btn-success btn-block" onclick='comprarProducto(${producto.id})'>Comprar</button>
                                        <p class="mensaje-compra mt-2" id="mensaje-${producto.id}"></p>
                                    ` : `
                                        <div class="alert alert-secondary">Vendido</div>
                                    `}
                                </div>
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

function listarPorCategoriaProducto(categoria) {
    console.log("Listar por categoria:", categoria);

    // Enviar la categoría como un parámetro GET
    fetch(`../includes/controller/obtenerProductosController.php?categoria=${encodeURIComponent(categoria)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            const productosContainer = document.getElementById('productos');

            // Vaciar el contenedor antes de mostrar nuevos productos
            productosContainer.innerHTML = '';

            if (data.length === 0) {
                productosContainer.innerHTML = '<p>No hay productos disponibles.</p>';
            } else {
                let productosHtml = '';
                data.forEach(producto => {
                    productosHtml += `
                        <div class="producto card mb-4" id="producto-${producto.id}">
                            <div class="card-body">
                                <h2 class="card-title">${producto.nombreProducto}</h2>
                                <h3 class="card-subtitle mb-2 text-muted">Precio del producto: ${producto.precio}€</h3>
                                <p class="card-text">${producto.descripcionProducto}</p>
                                <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                                <img src="../${producto.rutaImagen}" class="img-fluid mb-3" style="height: 200px;" />
                                <div class="acciones-producto text-center">
                                    ${producto.estado.toLowerCase() === 'enventa' ? `
                                        <button class="btn btn-success btn-block" onclick='comprarProducto(${producto.id})'>Comprar</button>
                                        <p class="mensaje-compra mt-2" id="mensaje-${producto.id}"></p>
                                    ` : `
                                        <div class="alert alert-secondary">Vendido</div>
                                    `}
                                </div>
                            </div>
                        </div>
                    `;
                });
                productosContainer.innerHTML = productosHtml;
            }
        })
        .catch(error => console.error('Error al obtener los productos:', error));
}
