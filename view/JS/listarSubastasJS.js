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
        `).join('');
        /*
                    <div class="producto" id="productos-${producto.id}">
                        <div class="card-body">
                            <h3 class="producto-precio">Precio del producto</h3>
                            <h3 class="producto-precio-valor">${producto.precio}€</h3>
                            <p class="card-text"><strong>Categoría:</strong> ${producto.categoriaProducto}</p>
                            <h3 class="producto-descripcion">Descripcion:</h3>
                            <p class="producto-descripcion-valor">${producto.descripcionProducto}</p>
                            <p>
                                <div class="producto-actions">
                                    ${producto.estado.toLowerCase() === 'enventa' ? `
                                        <div class="form-group">
                                            <a href="modificarproducto_pantalla.php?id=${producto.id}" class="btn btn-blue">Modificar</a>
                                            <button class="btn btn-red" onclick='eliminarProducto(${producto.id})'>Eliminar</button>
                                        </div>
                                        <p class="mensaje-compra" id="mensaje-${producto.id}"></p>
                                    ` : `
                                        <div class="vendido">Vendido</div>
                                    `}
                                </div>
                            </p>
                          </div>
                      </div>

        */
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
