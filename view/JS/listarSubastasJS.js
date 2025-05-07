document.addEventListener("DOMContentLoaded", function () {
    cargarSubastas();
});

function cargarSubastas() {
    fetch('../includes/controller/obtenerSubastasController.php')
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

            let subastasHtml = '';
            data.forEach(subasta => {
                subastasHtml += `
                    <div class="subasta card mb-4" id="subasta-${subasta.id}">
                        <div class="card-body">
                            <h2 class="card-title">${subasta.nombreSubasta}</h2>
                            <p class="card-text">${subasta.descripcionSubasta}</p>
                            <p><strong>Precio original:</strong> ${subasta.precio_original}€</p>
                            <img src="../${subasta.rutaImagen}" class="img-fluid mb-3" />

                            <!-- Campo de puja -->
                            <div class="form-inline mb-2">
                                <input 
                                    type="number" 
                                    min="0.01" 
                                    step="0.01" 
                                    id="puja-${subasta.id}" 
                                    placeholder="Tu puja (€)" 
                                    class="form-control mr-2"
                                />
                                <button class="btn btn-success" onclick="pujar(${subasta.id})"> ¡Quiero pujar! </button>
                            </div>
                            <div id="mensaje-puja-${subasta.id}" class="text-muted"></div>
                        </div>
                    </div>
                `;
            });
            subastasContainer.innerHTML = subastasHtml;
        })
        .catch(error => console.error('Error al cargar las subastas:', error));
}

function pujar(idSubasta) {
    const input = document.getElementById(`puja-${idSubasta}`);
    const precio = parseFloat(input.value);
    const mensajeEl = document.getElementById(`mensaje-puja-${idSubasta}`);

    mensajeEl.textContent = '';
    mensajeEl.className = 'text-muted';

    if (isNaN(precio) || precio <= 0) {
        mensajeEl.textContent = 'Introduce un importe válido.';
        mensajeEl.className = 'text-danger';
        return;
    }

    fetch('../includes/controller/registerPujaController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idSubasta, precio })
    })
    .then(response => response.json().then(json => ({ status: response.status, body: json })))
    .then(({ status, body }) => {
        mensajeEl.textContent = body.message;
        mensajeEl.className = body.success ? 'text-success' : 'text-danger';
    })
    .catch(err => {
        console.error('Error al registrar puja:', err);
        mensajeEl.textContent = 'Error al enviar la puja.';
        mensajeEl.className = 'text-danger';
    });
}

