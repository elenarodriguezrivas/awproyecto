document.addEventListener("DOMContentLoaded", function() {
    // Asignar evento al botón de vaciar cesta
    const vaciarCestaBtn = document.getElementById('vaciar-cesta');
    if (vaciarCestaBtn) {
        vaciarCestaBtn.addEventListener('click', vaciarCesta);
    }
});

// Función para eliminar un producto específico de la cesta
function eliminarDeCesta(productoId) {
    fetch('../includes/controller/borrarProductoCestaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            productoId: productoId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            const mensajeElement = document.getElementById('mensaje-accion');
            mensajeElement.className = 'alert alert-success';
            mensajeElement.textContent = 'Producto eliminado correctamente';
            mensajeElement.style.display = 'block';
            
            // Ocultar el mensaje después de 3 segundos
            setTimeout(function() {
                mensajeElement.style.display = 'none';
            }, 3000);
            
            // Recargar la página para actualizar la cesta
            location.reload();
        } else {
            console.error('Error al eliminar el producto:', data.message);
            // Mostrar mensaje de error
            const mensajeElement = document.getElementById('mensaje-accion');
            mensajeElement.className = 'alert alert-danger';
            mensajeElement.textContent = 'Error al eliminar el producto: ' + data.message;
            mensajeElement.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Error al eliminar el producto:', error);
        // Mostrar mensaje de error
        const mensajeElement = document.getElementById('mensaje-accion');
        mensajeElement.className = 'alert alert-danger';
        mensajeElement.textContent = 'Error al comunicarse con el servidor';
        mensajeElement.style.display = 'block';
    });
}

// Función para vaciar la cesta completa
function vaciarCesta() {
    if (confirm('¿Estás seguro de que deseas vaciar toda la cesta?')) {
        fetch('../includes/controller/vaciarCestaController.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                const mensajeElement = document.getElementById('mensaje-accion');
                mensajeElement.className = 'alert alert-success';
                mensajeElement.textContent = 'Cesta vaciada correctamente';
                mensajeElement.style.display = 'block';
                
                // Recargar la página para actualizar la cesta
                location.reload();
            } else {
                console.error('Error al vaciar la cesta:', data.message);
                // Mostrar mensaje de error
                const mensajeElement = document.getElementById('mensaje-accion');
                mensajeElement.className = 'alert alert-danger';
                mensajeElement.textContent = 'Error al vaciar la cesta: ' + data.message;
                mensajeElement.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error al vaciar la cesta:', error);
            // Mostrar mensaje de error
            const mensajeElement = document.getElementById('mensaje-accion');
            mensajeElement.className = 'alert alert-danger';
            mensajeElement.textContent = 'Error al comunicarse con el servidor';
            mensajeElement.style.display = 'block';
        });
    }
}

// Mantener las funciones existentes que puedas necesitar
function cargarProductos() {
    fetch('../includes/controller/obtenerCestaController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            const productosContainer = document.getElementById('productos');
            const totalPrecioContainer = document.getElementById('total-precio');

            if (!productosContainer || !totalPrecioContainer) {
                console.error('Elementos del DOM no encontrados.');
                return;
            }

            if (data.success) {
                let productosHtml = '';
                let total = 0; // Inicializar el total

                data.productos.forEach(producto => {
                    total += parseFloat(producto.precio); // Sumar el precio del producto al total
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
                        <button class="btn btn-danger btn-sm" onclick="eliminarDeCesta(${producto.id})" style="margin-left: auto;">Eliminar</button>
                    </div>
                `;
                });

                productosContainer.innerHTML = productosHtml;
                totalPrecioContainer.textContent = total.toFixed(2); // Actualizar el precio total con 2 decimales
            } else {
                productosContainer.innerHTML = `<p>${data.message}</p>`;
                totalPrecioContainer.textContent = '0.00'; // Mostrar total como 0 si no hay productos
            }
        })
        .catch(error => {
            console.error('Error al obtener los productos:', error);
            const productosContainer = document.getElementById('productos');
            const totalPrecioContainer = document.getElementById('total-precio');

            if (productosContainer) {
                productosContainer.innerHTML = `
                    <p>Ocurrió un error al cargar los productos. Inténtalo de nuevo más tarde.</p>
                    <p><strong>Error técnico:</strong> ${error.message}</p>
                `;
            }

            if (totalPrecioContainer) {
                totalPrecioContainer.textContent = '0.00'; // Mostrar total como 0 en caso de error
            }
        });
}

function procederPago() {
    fetch('../includes/controller/comprarCestaController.php', {
        method: 'POST',
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                cargarProductos();
            } else {
                alert(data.message);
                if (data.errores) {
                    console.error('Errores:', data.errores);
                }
            }
        })
        .catch(error => {
            console.log(error.message);
            console.error('Error al procesar el pago:', error);
            alert('Ocurrió un error al procesar el pago. Inténtalo de nuevo más tarde.');
        });
}