let paginaActual = 1;
let productosPorPagina = 10; // Valor inicial, se puede cambiar dinámicamente
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
        method: 'GET',
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
                    <div class="producto" id="producto-${producto.id}">
                        <div class="card-body">
                            <h2 class="producto-titulo">${producto.nombreProducto} </h2>
                            <h3 class="producto-precio-valor">${producto.precio}€</h3>
                            <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                            <h3 class="producto-descripcion">Descripcion:</h3>
                            <p class="producto-descripcion-valor">${producto.descripcionProducto}</p>
                            <div class="imagen-contenedor text-center"> <img src="../${producto.rutaImagen}" alt="${producto.nombreProducto}"/> </div>

                            <div class="producto-actions">
                                ${producto.estado.toLowerCase() === 'enventa' ? `
                                    <div class="form-group">
                                        <button class="btn btn-primary" onclick="agregarACesta(${producto.id})">Añadir a la cesta</button>
                                    </div>
                                    <p class="mensaje-compra" id="mensaje-${producto.id}"></p>
                                ` : `
                                    <div class="vendido">Vendido</div>
                                `}
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