$(document).ready(function() {
    $.ajax({
        url: '../includes/controller/obtenerPerfilController.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                window.location.href = 'login_pantalla.php';
            } else {
                $('#nombre').text(data.nombre);
                $('#apellidos').text(data.apellidos);
                $('#edad').text(data.edad);
                $('#correo').text(data.correo);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al obtener el perfil:', textStatus, errorThrown);
        }
    });
});