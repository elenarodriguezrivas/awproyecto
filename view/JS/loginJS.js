document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch("../includes/controller/loginUsuarioController.php", {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        document.getElementById('message').classList.add('error');
        return response.text();
    })
    .then(data => {
        document.getElementById('message').innerHTML = data;
        if (data.includes("Login exitoso")) {
            document.getElementById('message').classList.add('success');
            window.location.href = "perfil_pantalla.php";
        }
    })
    .catch(error => {
        document.getElementById('message').innerHTML = 'Error al iniciar sesión: ' + error.message;
    });
});