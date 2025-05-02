document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerCestaController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            const productosContainer = document.getElementById('productos');

            if (data.success) {
                let productosHtml = '';
                data.productos.forEach(producto => {
                    productosHtml += `
                    <div class="card producto d-flex align-items-center" id="producto-${producto.id}" style="margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px; display: flex; flex-direction: row; gap: 15px;">
                        <img src="../${producto.rutaImagen}" alt="${producto.nombreProducto}" style="width: 150px; height: auto; border-radius: 8px;">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; width: 100%;">
                            <h2 style="grid-column: span 2;">${producto.nombreProducto}</h2>
                            <p><strong>Descripción:</strong> ${producto.descripcionProducto}</p>
                            <p><strong>Precio:</strong> ${producto.precio}€</p>
                            <p><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                            <p><strong>Vendedor ID:</strong> ${producto.vendedorId}</p>
                            <p><strong>Estado:</strong> ${producto.estado}</p>
                        </div>
                    </div>
                `;
                });
                productosContainer.innerHTML = productosHtml;
            } else {
                productosContainer.innerHTML = `<p>Error: ${data.message}</p>`;
            }
        })
        .catch(error => {
            console.error('Error al obtener los productos:', error);
            const productosContainer = document.getElementById('productos');
            productosContainer.innerHTML = `
                <p>Ocurrió un error al cargar los productos. Inténtalo de nuevo más tarde.</p>
                <p><strong>Error técnico:</strong> ${error.message}</p>
            `;
        });
});