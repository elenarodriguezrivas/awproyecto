document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerSubastasUserController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las subastas');
            }
            return response.json();
        })
        .then(data => {
            const subastasContainer = document.getElementById('subastas');

            if (data.length === 0) {
                subastasContainer.innerHTML = '<p>No hay subastas disponibles.</p>';
            } else {
                const ahora = new Date();
                let subastasHtml = '';
                data.forEach(subasta => {
                    /*subastasHtml += `
                        <div class="subasta" id="subasta-${subasta.id}">
                            <div class="subasta-info">
                                <h2>${subasta.nombreSubasta}</h2>
                                <h3>Precio actual de la subasta: ${subasta.precio_actual}€</h3>
                                <h4>Precio original de la subasta: ${subasta.precio_original}€</h4>
                                <p>${subasta.descripcionSubasta}</p>
                                <p><img src="../${subasta.rutaImagen}" alt="${subasta.nombreSubasta}" /></p>
                                <p>
                                <div class="subasta-actions">
                                    ${subasta.estado.toLowerCase() === 'en_subasta' ? `
                                        <div class="form-group">
                                            <a href="modificarsubasta_pantalla.php?id=${subasta.id}" class="btn btn-blue">Modificar</a>
                                            <button class="btn btn-red" onclick='eliminarSubasta(${subasta.id})'>Eliminar</button>
                                        </div>
                                        <p class="mensaje-subasta" id="mensaje-${subasta.id}"></p>
                                    ` : `
                                        <div class="vendido">Vendido</div>
                                    `}
                                </div>
                                </p>
                            </div>
                        </div>
                    `;*/

                    const fechaSubasta = new Date(subasta.fechaSubasta + 'T' + subasta.horaSubasta);
                    let contenidoAcciones = '';

                    if (subasta.estado.toLowerCase() === 'anulada') {
                        contenidoAcciones = `<p class="mensaje-subasta estado-anulada">Subasta anulada</p>`;
                    } else if ( subasta.estado.toLowerCase() === 'finalizada' || fechaSubasta < ahora ) {
                        contenidoAcciones = `<p class="mensaje-subasta estado-finalizada">Subasta finalizada</p>`;
                    } else {
                        // en_subasta y aún activa
                        contenidoAcciones = `
                            <div class="form-group">
                                <a href="modificarsubasta_pantalla.php?id=${subasta.id}" class="btn btn-blue">Modificar</a>
                                <button class="btn btn-red" onclick='eliminarSubasta(${subasta.id})'>Eliminar</button>
                            </div>
                            <p class="mensaje-subasta" id="mensaje-${subasta.id}"></p>
                        `;
                    }

                    subastasHtml += `
                        <div class="subasta" id="subasta-${subasta.id}">
                            <div class="subasta-info">
                                <h2>${subasta.nombreSubasta}</h2>
                                <h3>Precio actual de la subasta: ${subasta.precio_actual}€</h3>
                                <h4>Precio original de la subasta: ${subasta.precio_original}€</h4>
                                <p>${subasta.descripcionSubasta}</p>
                                <p><img src="../${subasta.rutaImagen}" alt="${subasta.nombreSubasta}" /></p>
                                <div class="subasta-actions">
                                    ${contenidoAcciones}
                                </div>
                            </div>
                        </div>
                    `;
                });
                subastasContainer.innerHTML = subastasHtml;
            }
        })
        .catch((error) => {
            console.error('Error al obtener las subastas:', error);
            window.location.href = 'login_pantalla.php';
        });
});

function eliminarSubasta(subastaId) {
    if (!confirm("¿Estás seguro de que deseas eliminar esta subasta?")) {
        return; // Si el usuario cancela, no se realiza ninguna acción
    }

    fetch('../includes/controller/eliminarSubastaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: subastaId }), // Enviar el ID de la subasta como JSON
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.text();
        })
        .then(data => {
            alert(data); // Mostrar el mensaje del servidor
            // Eliminar la subasta del DOM
            const subastaElemento = document.getElementById(`subasta-${subastaId}`);
            if (subastaElemento) {
                subastaElemento.remove();
            }
        })
        .catch(error => {
            console.error('Error al eliminar la subasta:', error);
            alert('Error al eliminar la subasta: ' + error.message);
        });
}
