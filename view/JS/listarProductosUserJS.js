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

            if (data.length === 0) {
                productosContainer.innerHTML = '<p>No hay productos disponibles.</p>';
            } else {
                let productosHtml = '';
                data.forEach(producto => {
                    productosHtml += `
                        <div class="producto">
                            <h3>${producto.nombreProducto}</h3>
                            <p>${producto.descripcionProducto}</p>
                            <p>Precio: ${producto.precio}€</p>
                            <p>Categoría: ${producto.categoriaProducto}</p>
                            <img src="../${producto.rutaImagen}" style="height: 200px;" />
                        </div>
                    `;
                });
                productosContainer.innerHTML = productosHtml;
            }
        })
        .catch(error => console.error('Error al obtener los productos:', error));
});
