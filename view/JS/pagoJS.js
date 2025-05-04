document.addEventListener("DOMContentLoaded", function () {
    // Cargar el resumen de la compra
    cargarResumenCompra();
    
    // Configurar el formulario de pago
    document.getElementById('formPago').addEventListener('submit', function(event) {
        event.preventDefault();
        procesarPago();
    });
    
    // Detectar cambios en el método de pago
    document.querySelectorAll('input[name="metodoPago"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            mostrarFormularioPago(this.value);
        });
    });
    
    // Mostrar inicialmente el formulario de tarjeta
    mostrarFormularioPago('tarjeta');
});

/**
 * Función para cargar el resumen de la compra desde la base de datos
 */
function cargarResumenCompra() {
    const resumenContainer = document.getElementById('resumen-compra');
    const totalElement = document.getElementById('total-pago');

    // Obtener los productos seleccionados desde el servidor
    fetch('../includes/controller/obtenerProductosCestaController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(productos => {
            if (productos.length === 0) {
                window.location.href = 'cesta_pantalla.php';
                return;
            }

            let resumenHTML = '';
            let total = 0;

            productos.forEach(producto => {
                const subtotal = producto.precio * (producto.cantidad || 1); // Ajusta según la cantidad
                total += subtotal;

                resumenHTML += `
                    <div class="d-flex justify-content-between mb-2">
                        <span>${producto.nombre} x ${producto.cantidad || 1}</span>
                        <span>${subtotal.toFixed(2)}€</span>
                    </div>
                `;
            });

            // Agregar gastos de envío (ejemplo: 4.99€)
            const gastosEnvio = 4.99;
            total += gastosEnvio;

            resumenHTML += `
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Gastos de envío</span>
                    <span>${gastosEnvio.toFixed(2)}€</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>${total.toFixed(2)}€</strong>
                </div>
            `;

            // Actualizar el HTML del resumen
            resumenContainer.innerHTML = resumenHTML;
            totalElement.textContent = total.toFixed(2);

            // Guardar el total en un campo oculto para el formulario
            document.getElementById('totalCompra').value = total.toFixed(2);
        })
        .catch(error => {
            console.error('Error al cargar el resumen de la compra:', error);
        });
}

/**
 * Función para mostrar el formulario de pago correspondiente
 * @param {string} metodo - Método de pago seleccionado
 */
function mostrarFormularioPago(metodo) {
    // Ocultar todos los formularios
    document.querySelectorAll('.metodo-pago-form').forEach(form => {
        form.style.display = 'none';
    });
    
    // Mostrar el formulario correspondiente
    document.getElementById(`${metodo}-form`).style.display = 'block';
}

/**
 * Función para procesar el pago
 */
function procesarPago() {
    // Obtener el método de pago seleccionado
    const metodoPago = document.querySelector('input[name="metodoPago"]:checked').value;
    
    // Mostrar pantalla de carga
    document.getElementById('loading').style.display = 'flex';
    
    // Simular procesamiento del pago (3 segundos)
    setTimeout(function() {
        // Ocultar pantalla de carga
        document.getElementById('loading').style.display = 'none';
        
        // Simular conexión con RedSys
        simularPasarelaRedSys(metodoPago);
    }, 3000);
}

/**
 * Función para simular la conexión con RedSys
 * @param {string} metodoPago - Método de pago seleccionado
 */
function simularPasarelaRedSys(metodoPago) {
    // Ocultar el formulario de pago
    document.getElementById('pago-container').style.display = 'none';
    
    // Mostrar pantalla de simulación de RedSys
    const redsysContainer = document.getElementById('redsys-container');
    redsysContainer.style.display = 'block';
    
    // Configurar los datos de la simulación
    document.getElementById('redsys-metodo').textContent = metodoPago.toUpperCase();
    document.getElementById('redsys-monto').textContent = document.getElementById('totalCompra').value + '€';
    
    // Temporizador para la simulación
    let segundos = 5;
    const contadorElement = document.getElementById('redsys-contador');
    
    const countdown = setInterval(function() {
        segundos--;
        contadorElement.textContent = segundos;
        
        if (segundos <= 0) {
            clearInterval(countdown);
            finalizarPago();
        }
    }, 1000);
    
    // Configurar botón de cancelar
    document.getElementById('redsys-cancelar').addEventListener('click', function() {
        clearInterval(countdown);
        
        // Mostrar mensaje de cancelación
        document.getElementById('redsys-container').style.display = 'none';
        document.getElementById('pago-container').style.display = 'block';
        
        mostrarMensaje('Pago cancelado', 'danger');
    });
}

/**
 * Función para finalizar el proceso de pago
 */
function finalizarPago() {
    // Enviar los datos al servidor
    fetch('../includes/controller/finalizarCompraController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            cesta: JSON.parse(localStorage.getItem('cesta')) || [],
            total: document.getElementById('totalCompra').value,
            metodo: document.querySelector('input[name="metodoPago"]:checked').value
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.json();
    })
    .then(data => {
        // Vaciar la cesta
        localStorage.removeItem('cesta');
        
        // Redirigir a la página de confirmación
        window.location.href = `confirmacion_pantalla.php?pedido=${data.idPedido}`;
    })
    .catch(error => {
        console.error('Error al procesar el pago:', error);
        
        // Mostrar mensaje de error
        document.getElementById('redsys-container').style.display = 'none';
        document.getElementById('pago-container').style.display = 'block';
        
        mostrarMensaje(`Error al procesar el pago: ${error.message}`, 'danger');
    });
}

/**
 * Función para mostrar un mensaje
 * @param {string} mensaje - Mensaje a mostrar
 * @param {string} tipo - Tipo de mensaje (success, danger, etc.)
 */
function mostrarMensaje(mensaje, tipo = 'success') {
    const mensajeElement = document.createElement('div');
    mensajeElement.className = `alert alert-${tipo} alert-dismissible fade show`;
    mensajeElement.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.getElementById('mensajes').appendChild(mensajeElement);
    
    // Eliminar el mensaje después de 5 segundos
    setTimeout(() => {
        mensajeElement.remove();
    }, 5000);
}