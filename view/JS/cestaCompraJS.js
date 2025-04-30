document.addEventListener("DOMContentLoaded", function () {
    // Cargar el contenido de la cesta al iniciar la página
    cargarCesta();

    // Configurar el botón de proceder al pago
    document.getElementById('procederPago').addEventListener('click', function() {
        window.location.href = 'pago_pantalla.php';
    });
});

/**
 * Función para agregar un producto a la cesta
 * @param {number} productoId - ID del producto
 * @param {string} nombre - Nombre del producto
 * @param {number} precio - Precio del producto
 * @param {string} imagen - Ruta de la imagen del producto
 */
function agregarAlCarrito(productoId, nombre, precio, imagen) {
    // Obtener la cesta actual del localStorage
    let cesta = JSON.parse(localStorage.getItem('cesta')) || [];
    
    // Verificar si el producto ya está en la cesta
    const productoExistente = cesta.find(item => item.id === productoId);
    
    if (productoExistente) {
        // Si el producto ya existe, incrementar la cantidad
        productoExistente.cantidad += 1;
    } else {
        // Si no existe, añadirlo con cantidad 1
        cesta.push({
            id: productoId,
            nombre: nombre,
            precio: precio,
            imagen: imagen,
            cantidad: 1
        });
    }
    
    // Guardar la cesta actualizada en localStorage
    localStorage.setItem('cesta', JSON.stringify(cesta));
    
    // Mostrar mensaje de confirmación
    mostrarMensaje(`${nombre} añadido a la cesta`);
    
    // Actualizar el contador de productos en la cesta (opcional)
    actualizarContadorCesta();
}

/**
 * Función para cargar y mostrar el contenido de la cesta
 */
function cargarCesta() {
    const cestaContainer = document.getElementById('cesta-contenido');
    const totalElement = document.getElementById('total-precio');
    
    // Obtener la cesta del localStorage
    const cesta = JSON.parse(localStorage.getItem('cesta')) || [];
    
    // Si la cesta está vacía, mostrar mensaje
    if (cesta.length === 0) {
        cestaContainer.innerHTML = '<p class="text-center">Tu cesta está vacía</p>';
        totalElement.textContent = '0.00';
        document.getElementById('procederPago').disabled = true;
        return;
    }
    
    // Mostrar cada producto en la cesta
    let cestaHTML = '';
    let total = 0;
    
    cesta.forEach(producto => {
        const subtotal = producto.precio * producto.cantidad;
        total += subtotal;
        
        cestaHTML += `
            <div class="producto-cesta card mb-3" id="cesta-item-${producto.id}">
                <div class="row g-0">
                    <div class="col-md-2">
                        <img src="${producto.imagen}" class="img-fluid rounded-start" alt="${producto.nombre}">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h5 class="card-title">${producto.nombre}</h5>
                            <p class="card-text">${producto.precio}€ x ${producto.cantidad}</p>
                            <p class="card-text"><strong>Subtotal: ${subtotal.toFixed(2)}€</strong></p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary" onclick="cambiarCantidad(${producto.id}, -1)">-</button>
                            <span class="btn btn-sm btn-outline-secondary" id="cantidad-${producto.id}">${producto.cantidad}</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="cambiarCantidad(${producto.id}, 1)">+</button>
                        </div>
                        <button class="btn btn-sm btn-danger ms-2" onclick="eliminarDeCesta(${producto.id})">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    // Actualizar el HTML de la cesta
    cestaContainer.innerHTML = cestaHTML;
    totalElement.textContent = total.toFixed(2);
    document.getElementById('procederPago').disabled = false;
}

/**
 * Función para cambiar la cantidad de un producto en la cesta
 * @param {number} productoId - ID del producto
 * @param {number} cambio - Cantidad a cambiar (-1 o 1)
 */
function cambiarCantidad(productoId, cambio) {
    // Obtener la cesta del localStorage
    let cesta = JSON.parse(localStorage.getItem('cesta')) || [];
    
    // Encontrar el producto
    const productoIndex = cesta.findIndex(item => item.id === productoId);
    
    if (productoIndex !== -1) {
        // Actualizar cantidad
        cesta[productoIndex].cantidad += cambio;
        
        // Si la cantidad es 0 o menos, eliminar el producto
        if (cesta[productoIndex].cantidad <= 0) {
            cesta.splice(productoIndex, 1);
        }
        
        // Guardar la cesta actualizada
        localStorage.setItem('cesta', JSON.stringify(cesta));
        
        // Recargar la cesta para reflejar los cambios
        cargarCesta();
        actualizarContadorCesta();
    }
}

/**
 * Función para eliminar un producto de la cesta
 * @param {number} productoId - ID del producto a eliminar
 */
function eliminarDeCesta(productoId) {
    // Obtener la cesta del localStorage
    let cesta = JSON.parse(localStorage.getItem('cesta')) || [];
    
    // Filtrar la cesta para eliminar el producto
    cesta = cesta.filter(item => item.id !== productoId);
    
    // Guardar la cesta actualizada
    localStorage.setItem('cesta', JSON.stringify(cesta));
    
    // Recargar la cesta para reflejar los cambios
    cargarCesta();
    actualizarContadorCesta();
    
    // Mostrar mensaje
    mostrarMensaje('Producto eliminado de la cesta');
}

/**
 * Función para vaciar completamente la cesta
 */
function vaciarCesta() {
    // Confirmar antes de vaciar
    if (confirm('¿Estás seguro de que quieres vaciar la cesta?')) {
        // Vaciar la cesta en localStorage
        localStorage.removeItem('cesta');
        
        // Recargar la cesta
        cargarCesta();
        actualizarContadorCesta();
        
        // Mostrar mensaje
        mostrarMensaje('Cesta vaciada');
    }
}

/**
 * Función para actualizar el contador de productos en la cesta
 */
function actualizarContadorCesta() {
    const cesta = JSON.parse(localStorage.getItem('cesta')) || [];
    const contador = cesta.reduce((total, item) => total + item.cantidad, 0);
    
    // Actualizar el contador en la interfaz
    const contadorElement = document.getElementById('contador-cesta');
    if (contadorElement) {
        contadorElement.textContent = contador;
        contadorElement.style.display = contador > 0 ? 'block' : 'none';
    }
}

/**
 * Función para mostrar un mensaje temporal
 * @param {string} mensaje - Mensaje a mostrar
 */
function mostrarMensaje(mensaje) {
    const mensajeElement = document.createElement('div');
    mensajeElement.className = 'alert alert-success alert-dismissible fade show';
    mensajeElement.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.getElementById('mensajes').appendChild(mensajeElement);
    
    // Eliminar el mensaje después de 3 segundos
    setTimeout(() => {
        mensajeElement.remove();
    }, 3000);
}