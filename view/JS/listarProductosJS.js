$(document).ready(function() {
    $.ajax({
        url: '../includes/controller/listarProductosController.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                alert(data.error);
            } else {
                data.forEach(function(producto) {
                    $('#productos').append(
                        '<div class="producto">' +
                        '<h3>' + producto.nombre + '</h3>' +
                        '<p>' + producto.descripcion + '</p>' +
                        '<p>' + producto.precio + '</p>' +
                        '</div>'
                    );
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al listar productos:', textStatus, errorThrown);
        }
    });
});