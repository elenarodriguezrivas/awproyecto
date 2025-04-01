document.getElementById('modificarPerfilForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch("../includes/controller/modificarPerfilController.php", {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        return response.text();
    })
    .then(data => {
        document.getElementById('message').innerHTML = data;
        document.getElementById('message').classList.add('success');
        document.getElementById('message').classList.remove('error');
        
        // Redireccionar después de 2 segundos
        setTimeout(function() {
            window.location.href = "perfil_pantalla.php";
        }, 2000);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = 'Error al actualizar el perfil: ' + error.message;
        document.getElementById('message').classList.add('error');
        document.getElementById('message').classList.remove('success');
    });
});