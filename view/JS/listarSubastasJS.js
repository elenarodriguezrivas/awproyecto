document.addEventListener("DOMContentLoaded", function () {
    cargarSubastas();
});

function cargarSubastas() {
    fetch('../includes/controller/obtenerSubastasController.php')
        .then(res => {
            if (!res.ok) throw new Error('Error al obtener subastas');
            return res.json();
        })
        .then(data => {
            const cont = document.getElementById('subastas');
            cont.innerHTML = '';

            if (!data.length) {
                cont.innerHTML = '<p>No hay subastas disponibles.</p>';
                return;
            }

            cont.innerHTML = data.map(s => `
                <div class="subasta card mb-4" id="subasta-${s.id}">
                  <div class="card-body">
                    <h2>${s.nombreSubasta}</h2>
                    <p>${s.descripcionSubasta}</p>
                    <p><strong>Precio actual:</strong> ${s.precio_actual}€</p>
                    <img src="../${s.rutaImagen}" class="img-fluid mb-3">

                    <div class="form-inline mb-2">
                      <input
                        type="number"
                        min="${s.precio_actual}"
                        step="1.00"
                        id="puja-${s.id}"
                        placeholder="${s.precio_actual}€"
                        class="form-control mr-2"
                      />
                      <button class="btn btn-success" onclick="pujar(${s.id})"> pujar!</button>
                    </div>
                    <div id="mensaje-puja-${s.id}" class="text-muted"></div>
                  </div>
                </div>
            `).join('');
        })
        .catch(err => {
            console.error(err);
            document.getElementById('subastas')
                .innerHTML = '<p>Error cargando subastas.</p>';
        });
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

    // Enviar como form-urlencoded
    const body = new URLSearchParams();
    body.append('idSubasta', idSubasta);
    body.append('precio', precio);

    fetch('../includes/controller/registerPujaController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString()
    })
    .then(res => res.text().then(txt => ({ status: res.status, text: txt })))
    .then(({ status, text }) => {
        // el controller devuelve directamente el mensaje
        if (status === 201) {
            mensajeEl.textContent = text;
            mensajeEl.className = 'text-success';
        } else {
            mensajeEl.textContent = text;
            mensajeEl.className = 'text-danger';
        }
    })
    .catch(err => {
        console.error(err);
        mensajeEl.textContent = 'Error enviando la puja.';
        mensajeEl.className = 'text-danger';
    });
}
