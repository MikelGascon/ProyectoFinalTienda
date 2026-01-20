document.getElementById('form-login').addEventListener('submit', function (e) {
    e.preventDefault();

    const btn = document.getElementById('btn-login');
    const respuestaDiv = document.getElementById('respuesta-login');
    const formData = new FormData(this);

    btn.disabled = true;
    btn.innerText = "PROCESANDO...";
    respuestaDiv.style.display = 'none';

    fetch('../src/procesos/procesar_login.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            respuestaDiv.style.display = 'block';
            respuestaDiv.innerText = data.mensaje;
            respuestaDiv.className = data.status === 'success' ? 'exito' : 'error';

            if (data.status === 'success') {
                btn.innerText = "ACCESO CONCEDIDO";

                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1500);
            } else {
                btn.disabled = false;
                btn.innerText = "Entrar";
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerText = "Entrar";
            respuestaDiv.style.display = 'block';
            respuestaDiv.className = 'error';
            respuestaDiv.innerText = "Error técnico: revisa login.php";
            console.error('Error:', error);
        });
});