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
            subastasContainer.innerHTML = '';

            if (data.length === 0) {
                subastasContainer.innerHTML = '<p>No hay subastas disponibles.</p>';
                return;
            }

            const ahora = new Date();
            let subastasHtml = '';

            data.forEach(subasta => {
                const fechaSubasta = new Date(subasta.fechaSubasta + 'T' + subasta.horaSubasta);
                let contenidoAcciones = '';

                if (subasta.estado.toLowerCase() === 'anulada') {
                    contenidoAcciones = `<p class="text-danger">Subasta anulada</p>`;
                } else if (subasta.estado.toLowerCase() === 'finalizada' || fechaSubasta < ahora) {
                    contenidoAcciones = `<p class="text-muted">Subasta finalizada</p>`;
                } else {
                    contenidoAcciones = `
                        <a href="modificarsubasta_pantalla.php?id=${subasta.id}" class="btn btn-primary mr-2">Modificar</a>
                        <button class="btn btn-danger" onclick="eliminarSubasta(${subasta.id})">Eliminar</button>
                        <p id="mensaje-${subasta.id}" class="mt-2 text-muted"></p>
                    `;
                }

                subastasHtml += `
                    <div class="card mb-4" id="subasta-${subasta.id}">
                        <div class="card-header bg-light text-dark">
                            <h5 class="mb-0">${subasta.nombreSubasta}</h5>
                        </div>
                        <div class="card-body d-flex">
                            <div class="mr-4" style="flex: 0 0 200px;">
                                <img src="../${subasta.rutaImagen}" alt="${subasta.nombreSubasta}" class="img-fluid rounded">
                            </div>
                            <div style="flex: 1;">
                                <p><strong>Precio actual:</strong> ${subasta.precio_actual}€</p>
                                <p><strong>Precio original:</strong> ${subasta.precio_original}€</p>
                                <p><strong>Fecha:</strong> ${subasta.fechaSubasta}</p>
                                <p><strong>Hora:</strong> ${subasta.horaSubasta}</p>
                                <p>${subasta.descripcionSubasta}</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            ${contenidoAcciones}
                        </div>
                    </div>
                `;
            });

            subastasContainer.innerHTML = subastasHtml;
        })
        .catch((error) => {
            console.error('Error al obtener las subastas:', error);
            window.location.href = 'login_pantalla.php';
        });
});

function eliminarSubasta(subastaId) {
    if (!confirm("¿Estás seguro de que deseas eliminar esta subasta?")) return;

    fetch('../includes/controller/eliminarSubastaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: subastaId }),
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.text();
        })
        .then(data => {
            alert(data);
            const subastaElemento = document.getElementById(`subasta-${subastaId}`);
            if (subastaElemento) subastaElemento.remove();
        })
        .catch(error => {
            console.error('Error al eliminar la subasta:', error);
            alert('Error al eliminar la subasta: ' + error.message);
        });
}
