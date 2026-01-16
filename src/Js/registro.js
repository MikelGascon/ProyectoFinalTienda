document.getElementById('form-registro').addEventListener('submit', function (e) {
    e.preventDefault(); // Detener la recarga de la página

    const btn = document.getElementById('btn-enviar');
    const respuestaDiv = document.getElementById('respuesta');
    const formData = new FormData(this);

    // Feedback visual inmediato
    btn.disabled = true;
    btn.innerText = "PROCESANDO...";
    respuestaDiv.style.display = 'none';

    // Petición AJAX al servidor
    fetch('../src/procesos/procesar_registro.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            respuestaDiv.style.display = 'block';
            respuestaDiv.innerText = data.mensaje;
            respuestaDiv.className = data.status === 'success' ? 'exito' : 'error';

            if (data.status === 'success') {
                document.getElementById("form-registro").reset();
                btn.innerText = "¡REGISTRO COMPLETADO!";
                // Redirección al login tras 1.5 segundos
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 1500);
            } else {
                // Si hay error, rehabilitar el botón para intentar de nuevo
                btn.disabled = false;
                btn.innerText = "CREAR CUENTA";
            }
        })
        .catch(error => {
            // En caso de fallo técnico (error 500, archivo no encontrado, etc)
            btn.disabled = false;
            btn.innerText = "CREAR CUENTA";
            respuestaDiv.style.display = 'block';
            respuestaDiv.className = 'error';
            respuestaDiv.innerText = "Error técnico: Asegúrate de que 'procesar_registro.php' existe.";
            console.error('Error:', error);
        });
});