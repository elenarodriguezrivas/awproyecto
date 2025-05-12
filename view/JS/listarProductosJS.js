let paginaActual = 1;
let productosPorPagina = 1; // Valor inicial, se puede cambiar dinámicamente
let categoriaActual = ''; // Categoría seleccionada (vacío significa "todas las categorías")

/**
 * Función para cargar productos con o sin categoría.
 * @param {number} pagina - Número de página a cargar.
 */
function cargarProductos(pagina = 1) {
    const productosContainer = document.getElementById('productos');
    productosContainer.innerHTML = ''; // Limpiar el contenedor antes de cargar nuevos productos

    // Construir la URL con los parámetros
    const url = `../includes/controller/obtenerProductosController.php?page=${pagina}&limit=${productosPorPagina}`;

    fetch(url, {
        method: 'GET', // Cambiar a GET
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            productosContainer.classList.add('productos-grid'); // Añade la clase para aplicar estilos

            // Filtrar los productos según la categoría seleccionada
            const productosFiltrados = categoriaActual
                ? data.productos.filter(producto => producto.categoriaProducto === categoriaActual)
                : data.productos;

            if (productosFiltrados.length === 0) {
                productosContainer.innerHTML = '<p>No hay productos disponibles en esta categoría.</p>';
                return;
            }

            let productosHtml = '';
            productosFiltrados.forEach(producto => {
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

/**
 * Función para actualizar la paginación.
 * @param {number} paginaActual - Página actual.
 * @param {number} totalPaginas - Número total de páginas.
 */
function actualizarPaginacion(paginaActual, totalPaginas) {
    const paginacionContainer = document.getElementById('paginacion'); // Asegúrate de que este ID exista en el HTML
    paginacionContainer.innerHTML = '';

    for (let i = 1; i <= totalPaginas; i++) {
        paginacionContainer.innerHTML += `
            <button class="btn ${i === paginaActual ? 'btn-primary' : 'btn-secondary'}" onclick="cargarProductos(${i})">
                ${i}
            </button>
        `;
    }
}

/**
 * Función para cargar las categorías en el desplegable.
 */
function cargarCategorias() {
    fetch('../includes/controller/obtenerCategoriasController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las categorías');
            }
            return response.json();
        })
        .then(data => {
            const categoriasSelect = document.getElementById('selectorCategoria');
            categoriasSelect.innerHTML = '<option value="">Todas las categorías</option>'; // Opción por defecto

            data.forEach(categoria => {
                categoriasSelect.innerHTML += `
                    <option value="${categoria.nombreCategoria}">${categoria.nombreCategoria}</option>
                `;
            });
        })
        .catch(error => console.error('Error al cargar las categorías:', error));
}

/**
 * Función para manejar el cambio de categoría desde el desplegable.
 * @param {string} categoria - Categoría seleccionada.
 */
function listarPorCategoriaProducto(categoria = '') {
    categoriaActual = categoria; // Actualizar la categoría actual
    cargarProductos(1); // Reiniciar a la primera página con la categoría seleccionada
}

/**
 * Función para cambiar el número de productos por página.
 * @param {number} nuevoLimite - Nuevo límite de productos por página.
 */
function cambiarProductosPorPagina(nuevoLimite) {
    productosPorPagina = parseInt(nuevoLimite, 10); // Actualizar el límite de productos por página
    cargarProductos(1); // Reiniciar a la primera página con el nuevo límite
}

// Inicializar al cargar la página
document.addEventListener("DOMContentLoaded", () => {
    cargarProductos(); // Cargar todos los productos por defecto
    cargarCategorias(); // Cargar las categorías en el desplegable

    // Configurar el selector de productos por página
    const productosPorPaginaSelector = document.getElementById('productosPorPaginaSelector');
    productosPorPaginaSelector.value = productosPorPagina; // Establecer el valor inicial
    productosPorPaginaSelector.addEventListener('change', (event) => {
        cambiarProductosPorPagina(event.target.value);
    });
});