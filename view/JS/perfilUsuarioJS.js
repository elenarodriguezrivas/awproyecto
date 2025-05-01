//Este archivo se encargará de llamar al endpoint obtenerCompras y mostrar los datos en la interfaz.
document.addEventListener("DOMContentLoaded", function () {
    // Cargar las compras del usuario al iniciar la página
    cargarComprasUsuario();
});

/**
 * Función para cargar y mostrar las compras del usuario
 */
function cargarComprasUsuario() {
    fetch('../includes/controller/ventasController.php?action=obtenerCompras')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las compras del usuario.');
            }
            return response.json();
        })
        .then(data => {
            const comprasContainer = document.getElementById('compras-container');

            if (data.success) {
                if (data.compras.length === 0) {
                    comprasContainer.innerHTML = '<p>No has realizado ninguna compra.</p>';
                } else {
                    let html = '';
                    data.compras.forEach(compra => {
                        html += `
                            <div class="compra-item card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">${compra.nombreProducto}</h5>
                                    <p class="card-text">Precio: ${compra.precio}€</p>
                                    <p class="card-text">Categoría: ${compra.categoriaProducto}</p>
                                    <img src="../${compra.rutaImagen}" alt="${compra.nombreProducto}" class="img-fluid" style="max-width: 150px;">
                                </div>
                            </div>
                        `;
                    });
                    comprasContainer.innerHTML = html;
                }
            } else {
                comprasContainer.innerHTML = `<p>Error: ${data.error || 'No se pudieron cargar las compras.'}</p>`;
            }
        })
        .catch(error => {
            console.error('Error al cargar las compras:', error);
            const comprasContainer = document.getElementById('compras-container');
            comprasContainer.innerHTML = '<p>Error al cargar las compras. Inténtalo más tarde.</p>';
        });
}