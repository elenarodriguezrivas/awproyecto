document.addEventListener("DOMContentLoaded", function () {
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
                    <div class="subasta card mb-4">
                        <div class="card-body">
                            <h2 class="card-title">${subasta.nombreSubasta}</h2>
                            <p class="card-text">${subasta.descripcionSubasta}</p>
                            <p><strong>Precio original:</strong> ${subasta.precio_original}€</p>
                            <img src="../${subasta.rutaImagen}" class="img-fluid" />
                        </div>
                    </div>
                `;
            });
            subastasContainer.innerHTML = subastasHtml;
        })
        .catch(error => console.error('Error al cargar las subastas:', error));
});

