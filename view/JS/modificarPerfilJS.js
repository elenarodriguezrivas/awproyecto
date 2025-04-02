document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formModificarPerfil').addEventListener('submit', function(event) {
        event.preventDefault();

        // Limpiar mensajes previos
        const messageElement = document.getElementById('message');
        messageElement.textContent = '';
        messageElement.classList.remove('success', 'error');
        
        // Obtener los datos del formulario
        const formData = new FormData(this);
        console.log(formData);
        // Enviar los datos al controlador
        fetch('../includes/controller/modificarPerfilController.php', {
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
            messageElement.textContent = data;
            messageElement.classList.add('success');
            
            // Redireccionar después de 2 segundos
            setTimeout(function() {
                window.location.href = "perfil_pantalla.php";
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            messageElement.textContent = 'Error al actualizar el perfil: ' + error.message;
            messageElement.classList.add('error');
        });
    });
});