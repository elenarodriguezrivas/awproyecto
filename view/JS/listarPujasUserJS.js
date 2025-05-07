document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerPujasUserController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las pujas');
            }
            return response.json();
        })
        .then(data => {
            const pujasContainer = document.getElementById('pujas');
            pujasContainer.innerHTML = '';

            if (data.length === 0) {
                pujasContainer.innerHTML = '<p>No hay pujas disponibles.</p>';
                return;
            }

            let pujasHtml = '';

            data.forEach(puja => {
                let contenidoAcciones = '';

                pujasHtml += `
                    <div class="card mb-4" id="subasta-${subasta.id}">
                        <div class="card-header bg-light text-dark">
                            <h5 class="mb-0">${subasta.nombreSubasta}</h5>
                        </div>
                        <div class="card-body d-flex">
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
