document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerPorCategoriaController.php')
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
                        <div class="productos">
                            <div class="card-body">
                                <h2 class="producto-titulo">Nombre Producto </h2>
                                <h2 class="producto-titulo-valor">${producto.nombreProducto} </h2>
                                <h3 class="producto-precio">Precio del producto</h3>
                                <h3 class="producto-precio-valor">${producto.precio}€</h3>
                                <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                                <h3 class="producto-descripcion">Descripcion:</h3>
                                <p class="producto-descripcion-valor">${producto.descripcionProducto}</p>
                                <div class="imagen-contenedor text-center"> <img src="../${producto.rutaImagen}" /> </div>
                                <!-- PARA LA PRACTICA 3 -->
                                <!--
                                <form action="../includes/controller/ComprarProductoController.php" method="POST">
                                    <input type="hidden" name="producto_id" value="${producto.id}">
                                    <input type="hidden" name="precio" value="${producto.precio}">
                                    <button type="submit" class="btn">Comprar</button>
                                </form>
                                -->
                            </div>
                        </div>
                    `;
                });
                productosContainer.innerHTML = productosHtml;
            }
        })
        .catch(error => console.error('Error al obtener los productos:', error));
});
