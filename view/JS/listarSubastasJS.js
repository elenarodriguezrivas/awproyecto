document.addEventListener('DOMContentLoaded', function() {
    // URL del backend donde se obtendrán las subastas
    const url = '../Subasta/controller/obtenerSubastasController.php';

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Si hay un error, mostrarlo
                document.getElementById('productos').innerHTML = `<p>Error: ${data.error}</p>`;
            } else {
                // Si hay subastas, mostrar los productos
                const productosDiv = document.getElementById('productos');
                productosDiv.innerHTML = ''; // Limpiar el div antes de mostrar los productos

                data.forEach(subasta => {
                    // Crear un contenedor para cada subasta con su producto
                    const productoHTML = `
                        <div class="producto-subasta">
                            <h3>${subasta.nombreProducto}</h3>
                            <img src="${subasta.rutaImagen}" alt="${subasta.nombreProducto}" />
                            <p>${subasta.descripcionProducto}</p>
                            <p>Precio inicial: $${subasta.precio}</p>
                            <p>Fecha de subasta: ${subasta.fechaSubasta}</p>
                            <p>Estado: ${subasta.estado}</p>
                        </div>
                    `;
                    productosDiv.innerHTML += productoHTML;
                });
            }
        })
        .catch(error => {
            document.getElementById('productos').innerHTML = `<p>Error al cargar las subastas: ${error}</p>`;
        });

w});
