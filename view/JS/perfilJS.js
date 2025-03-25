document.addEventListener("DOMContentLoaded", function () {
    fetch('../includes/controller/obtenerPerfilController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener el perfil');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                window.location.href = 'login_pantalla.php';
            } else {
                document.getElementById('nombre').textContent = data.nombre;
                document.getElementById('apellidos').textContent = data.apellidos;
                document.getElementById('edad').textContent = data.edad;
                document.getElementById('correo').textContent = data.correo;
            }
        })
        .catch(error => console.error('Error al obtener el perfil:', error));
});
