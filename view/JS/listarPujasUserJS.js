document.addEventListener("DOMContentLoaded", function () {
    //Listar las pujas hechas por el usuario
    fetch('../includes/controller/obtenerPujasUserController.php') 
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener las pujas realizadas por el usuario');
            }
            return response.json();
        })
        .then(data => {
            const pujasContainer = document.getElementById('pujas');

            if (data.length === 0) {
                pujasContainer.innerHTML = '<p>No hay pujas disponibles.</p>';
            } else {
                let pujasHtml = '';
                data.forEach(puja => {
                    //de momento solo muestra el id del producto pujado y el precio pero en el futuro se puede añadir
                    //el estado de la puja: si ya se ha subastado o no, y la imagen
                    pujasHtml += `
                        <div class="puja" id="puja-${puja.id}">
                            <h3>Id Producto pujado: ${puja.idProducto}</h3>
                            <h4>Precio: ${puja.precio}€</h4>
                            <button class="btn btn-red" onclick='eliminarPuja(${puja.id})'>Eliminar Puja</button>
                            <p class="mensaje-puja" id="mensaje-${puja.id}"></p>
                        </div>
                    `;
                });
                pujasContainer.innerHTML = pujasHtml;
            }
        })
        .catch(error => console.error('Error al obtener las pujas:', error));
});

/**
 * Función para eliminar una puja.
 * @param {number} pujaId - El ID de la puja a eliminar.
 */
function eliminarPuja(pujaId) {
    if (!confirm("¿Estás seguro de que deseas eliminar esta puja?")) {
        return; // Si el usuario cancela, no se realiza ninguna acción
    }

    fetch('../includes/controller/eliminarPujaController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: pujaId }), // Enviar el ID del puja como JSON
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.text();
        })
        .then(data => {
            alert(data); // Mostrar el mensaje del servidor
            // Eliminar la puja del DOM
            const pujaElemento = document.getElementById(`puja-${pujaId}`);
            if (pujaElemento) {
                pujaElemento.remove();
            }
        })
        .catch(error => {
            console.error('Error al eliminar la puja:', error);
            alert('Error al eliminar la puja: ' + error.message);
        });
}
