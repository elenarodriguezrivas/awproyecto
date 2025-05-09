document.getElementById('deleteForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("../includes/controller/eliminarSubastaController.php", {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Error en la respuesta");
        }
        return response.text();
    })
    .then(data => {
        let message = document.getElementById('message');
        message.innerHTML = data;
        message.classList.add('success');
        message.classList.remove('error');
    })
    .catch(error => {
        let message = document.getElementById('message');
        message.innerHTML = "Error al eliminar la subasta";
        message.classList.add('error');
        message.classList.remove('success');
    });
});
