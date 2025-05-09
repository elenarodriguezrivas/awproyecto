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
            /*
<div class="subasta card mb-4" id="subasta-${s.id}">
            <div class="card-header bg-secondary text-white">
              <h2 class="producto-titulo">${s.nombreSubasta} </h2>
            </div>
            <div class="card-body d-flex">
              <div class="imagen-contenedor text-center"> <img src="../${s.rutaImagen}" alt="${s.nombreSubasta}"/> </div>
              <hr class="linea-gris"> <!-- Línea horizontal gris -->
              <div style="flex: 1;">
                <h3 class="producto-precio-hora">Tiempo restante: ${s.horaSubasta}</h3>
                <h3 class="producto-precio-fecha">Fecha: ${s.fechaSubasta}</h3>
                <h3 class="producto-precio-valor">Precio actual: ${s.precio_actual}€</h3>
                <p class="producto-descripcion-valor">${s.descripcionSubasta}</p>
                <div class="mt-3">
                  <input type="number"
                         min="${s.precio_actual}"
                         step="1.00"
                         id="puja-${s.id}"
                         placeholder="${s.precio_actual}€"
                         class="form-control d-inline-block"
                         style="width: 120px;">
                  <button class="btn btn-success ml-2"
                          onclick="pujar(${s.id})">
                    ¡Pujar!
                  </button>
                  <div id="mensaje-puja-${s.id}" class="text-muted mt-2"></div>
                </div>
              </div>
            </div>
            <div class="card-footer text-muted">
              Estado: ${s.estado.replace('_',' ')}
            </div>
          </div>
            */
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
