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
            <div class="card-header bg-secondary text-white">
              <h5 class="mb-0">${s.nombreSubasta}</h5>
            </div>
            <div class="card-body d-flex">
              <div class="mr-4" style="flex: 0 0 200px;">
                <img src="../${s.rutaImagen}"
                     alt="${s.nombreSubasta}"
                     class="img-fluid rounded">
              </div>
              <div style="flex: 1;">
                <p><strong>Precio actual:</strong> ${s.precio_actual}€</p>
                <p><strong>Fecha:</strong> ${s.fechaSubasta}</p>
                <p><strong>Hora:</strong> ${s.horaSubasta}</p>
                <p>${s.descripcionSubasta}</p>
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
        `).join('');
      })
      .catch(err => {
        console.error(err);
        document.getElementById('subastas')
          .innerHTML = `<p class="text-danger">Error cargando subastas:<br>${err.message}</p>`;
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
