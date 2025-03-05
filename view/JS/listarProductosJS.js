$(document).ready(function() {
    $.ajax({
        url: '../includes/controller/listarProductosController.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                alert(data.error);
            } else {
                $('#nombre').text(data.nombre);
                $('#descripcion').text(data.descripción);
                $('#precio').text(data.precio);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al listar productos:', textStatus, errorThrown);
        }
    });
});