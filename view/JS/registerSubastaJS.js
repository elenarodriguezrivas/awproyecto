document.getElementById('subastaForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch("../includes/controller/registerSubastaController.php", {
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
        window.location.href = 'catalogo_subasta.php';
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = 'Error al registrar la subasta: ' + error.message;
        document.getElementById('message').classList.add('error');
        document.getElementById('message').classList.remove('success');
    });
});