let paginaActual = 1;
let productosPorPagina = 1; // Valor inicial, se puede cambiar dinámicamente

function cargarProductos(pagina = 1) {
    fetch(`../includes/controller/obtenerProductosController.php?page=${pagina}&limit=${productosPorPagina}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            const productosContainer = document.getElementById('productos');
            productosContainer.innerHTML = '';

            if (data.productos.length === 0) {
                productosContainer.innerHTML = '<p>No hay productos disponibles.</p>';
                return;
            }

            let productosHtml = '';
            data.productos.forEach(producto => {
                productosHtml += `
                    <div class="producto card mb-4" id="producto-${producto.id}">
                        <div class="card-body">
                            <h2 class="card-title">${producto.nombreProducto}</h2>
                            <h3 class="card-subtitle mb-2 text-muted">Precio del producto: ${producto.precio}€</h3>
                            <p class="card-text">${producto.descripcionProducto}</p>
                            <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                            <img src="../${producto.rutaImagen}" class="img-fluid mb-3" style="height: 200px;" />
                            <div class="acciones-producto text-center">
                                ${
                                    producto.estado.toLowerCase() === 'enventa' ? `
                                        <button class="btn btn-primary btn-block mb-2" onclick='agregarProductoACesta(${producto.id})'>Añadir al carrito</button>
                                        <button class="btn btn-success btn-block" onclick='comprarProducto(${producto.id})'>Comprar</button>
                                        <p class="mensaje-compra mt-2" id="mensaje-${producto.id}"></p>
                                    ` : `
                                        <div class="alert alert-secondary">Vendido</div>
                                    `
                                }
                            </div>
                        </div>
                    </div>
                `;
            });
            productosContainer.innerHTML = productosHtml;

            actualizarPaginacion(data.paginaActual, data.totalPaginas);
        })
        .catch(error => console.error('Error al cargar los productos:', error));
}

function actualizarPaginacion(paginaActual, totalPaginas) {
    const paginacionContainer = document.getElementById('paginacion');
    paginacionContainer.innerHTML = '';

    for (let i = 1; i <= totalPaginas; i++) {
        paginacionContainer.innerHTML += `
            <button class="btn ${i === paginaActual ? 'btn-primary' : 'btn-secondary'}" onclick="cargarProductos(${i})">
                ${i}
            </button>
        `;
    }
}

function cambiarProductosPorPagina(nuevoLimite) {
    if (nuevoLimite > 0 && nuevoLimite <= 20) {
        productosPorPagina = nuevoLimite;
        cargarProductos(1); // Reiniciar a la primera página
    }
}

document.addEventListener("DOMContentLoaded", () => {
    cargarProductos();
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
                                    ${
                                        producto.estado.toLowerCase() === 'enventa' ? `
                                            <button class="btn btn-primary btn-block mb-2" onclick='agregarProductoACesta(${producto.id})'>Añadir al carrito</button>
                                            <button class="btn btn-success btn-block" onclick='comprarProducto(${producto.id})'>Comprar</button>
                                            <p class="mensaje-compra mt-2" id="mensaje-${producto.id}"></p>
                                        ` : `
                                            <div class="alert alert-secondary">Vendido</div>
                                        `
                                    }
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

function agregarProductoACesta(productoId) {
    fetch('../includes/controller/agregarProductoCestaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            productoId: productoId
        })
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.text();
        })
        .then(data => {
            console.log('Producto agregado a la cesta:', data);
            // Opcional: Actualizar la interfaz o mostrar un mensaje de éxito
        })
        .catch(error => {
            console.error('Error al agregar el producto a la cesta:', error);
        });
}

