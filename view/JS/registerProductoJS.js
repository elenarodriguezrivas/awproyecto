document.getElementById('productForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch("../includes/controller/registerProductoController.php", {
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
        window.location.href = 'micatalogo_pantalla.php';
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = 'Error al registrar el producto: ' + error.message;
        document.getElementById('message').classList.add('error');
        document.getElementById('message').classList.remove('success');
    });
});