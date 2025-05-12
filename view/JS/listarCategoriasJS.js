document.addEventListener("DOMContentLoaded", function () {

    fetch('../includes/controller/obtenerCategoriasController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las categorias');
            }
            return response.json();
        })
        .then(data => {
            const categoriasContainer = document.getElementById('categorias');

            if (data.length === 0) {
                categoriasContainer.innerHTML = '<p>No hay categorias agregadas.</p>';
            } else {
                let categoriasHtml = '';
                data.forEach(categoria => {
                    categoriasHtml += `
                        <div class="col-12 mb-3 categoria" id="categoria-${categoria.nombreCategoria}">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="card-title">${categoria.nombreCategoria}</h3>
                                    <p><button class="btn btn-danger" onclick='eliminarCategoria("${categoria.nombreCategoria}")'>Eliminar</button></p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                categoriasContainer.innerHTML = categoriasHtml;
            }
        })
        .catch(error => console.error('Error al obtener los productos:', error));
});

/**
 * Función para eliminar un producto.
 * @param {string} nombre - El nombre de la categoria a eliminar.
 */
function eliminarCategoria(nombre) {
    if (!confirm("¿Estás seguro de que deseas eliminar esta categoría?")) return;

    fetch('../includes/controller/eliminarCategoriaController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ nombreCategoria: nombre })
    })
    .then(response => {
        if (!response.ok) throw new Error(response.statusText);
        return response.text();
    })
    .then(data => {
        // Verificamos si el mensaje del servidor incluye el error de productos asignados
        if (data.includes("No puedes eliminar esta categoría")) {
            // Si la respuesta incluye el mensaje de error, mostramos el mensaje
            alert(data);  // Muestra el mensaje de error de que la categoría tiene productos
        } else {
            alert(data);  // Muestra el mensaje de éxito
            // Eliminar la categoría del DOM sin recargar
            const categoriaElemento = document.getElementById(`categoria-${nombre}`);
            if (categoriaElemento) {
                categoriaElemento.remove();
            }

            // Mostrar mensaje si no quedan categorías
            if (document.querySelectorAll('.categoria').length === 0) {
                document.getElementById('categorias').innerHTML = '<p>No hay categorías agregadas.</p>';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar: ' + error.message);
    });
}
