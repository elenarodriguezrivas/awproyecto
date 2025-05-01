document.addEventListener("DOMContentLoaded", function () {
    cargarProductosComprados();
});

function cargarProductosComprados() {
    fetch('../includes/controller/ventasController.php?action=obtenerProductosComprados')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos comprados.');
            }
            return response.json();
        })
        .then(data => {
            const productosContainer = document.getElementById('cesta-contenido');

            if (data.success) {
                if (data.productos.length === 0) {
                    productosContainer.innerHTML = '<p>No has comprado ningún producto.</p>';
                } else {
                    let html = '';
                    data.productos.forEach(producto => {
                        html += `
                            <div class="producto-cesta card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-2">
                                        <img src="../${producto.rutaImagen}" class="img-fluid rounded-start" alt="${producto.nombreProducto}">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title">${producto.nombreProducto}</h5>
                                            <p class="card-text"><strong>Precio:</strong> ${producto.precio}€</p>
                                            <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    productosContainer.innerHTML = html;
                }
            } else {
                productosContainer.innerHTML = `<p>Error: ${data.error || 'No se pudieron cargar los productos comprados.'}</p>`;
            }
        })
        .catch(error => {
            console.error('Error al cargar los productos comprados:', error);
            const productosContainer = document.getElementById('cesta-contenido');
            productosContainer.innerHTML = '<p>Error al cargar los productos comprados. Inténtalo más tarde.</p>';
        });
}