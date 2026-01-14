<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro AJAX - El Corte Rebelde</title>
    <style>
        :root {
            --marron-claro: #AAA085; --marron-oscuro: #8C836A; --negro: #000000;
            --gris-medio: #878686; --gris-claro: #D9D9D9;
        }
        body { margin: 0; font-family: Arial, sans-serif; height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #fff; position: relative; overflow: hidden; }
        
        /* Fondo decorativo */
        body::before { content: ""; position: fixed; top: -50%; left: -50%; width: 200%; height: 200%; background-image: url('../src/img/logo-rebelde.png'); background-repeat: repeat; background-size: 140px; opacity: 0.08; transform: rotate(-35deg); z-index: -1; }

        .login-box { background-color: #fff; border-radius: 14px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18); width: 420px; overflow: hidden; }
        .login-header { background: linear-gradient(to bottom, var(--marron-claro), var(--marron-oscuro)); padding: 20px; text-align: center; }
        .login-header img { max-width: 150px; }
        .login-body { padding: 25px 40px; background-color: var(--gris-claro); }
        .login-body label { display: block; margin-bottom: 4px; font-size: 0.85rem; font-weight: bold; }
        .login-body input { width: 100%; padding: 10px; margin-bottom: 12px; border: 1px solid var(--gris-medio); border-radius: 6px; box-sizing: border-box; }
        .login-body button { width: 100%; padding: 12px; background-color: var(--marron-claro); color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 1rem; }
        
        /* Estilos de respuesta AJAX */
        #respuesta { margin-top: 15px; padding: 10px; border-radius: 4px; text-align: center; font-size: 0.9rem; display: none; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .exito { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-header">
        <img src="../src/img/logo-rebelde.png" alt="El Corte Rebelde">
    </div>

    <div class="login-body">
        <form id="form-registro">
            <label>Nombre Completo</label>
            <input type="text" name="nombre" required>

            <label>Correo Electrónico</label>
            <input type="email" name="email" required>

            <label>Usuario</label>
            <input type="text" name="usuario" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <label>Confirmar Contraseña</label>
            <input type="password" name="confirm_password" required>

            <button type="submit" id="btn-enviar">CREAR CUENTA</button>
        </form>

        <div id="respuesta"></div>
    </div>
</div>

<script>
document.getElementById('form-registro').addEventListener('submit', function(e) {
    e.preventDefault(); // Evitar que la página se recargue

    const btn = document.getElementById('btn-enviar');
    const respuestaDiv = document.getElementById('respuesta');
    const formData = new FormData(this);

    btn.disabled = true;
    btn.innerText = "Procesando...";

    fetch('procesar_registro.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        respuestaDiv.style.display = 'block';
        respuestaDiv.innerText = data.mensaje;
        respuestaDiv.className = data.status === 'success' ? 'exito' : 'error';
        
        if(data.status === 'success') {
            document.getElementById('form-registro').reset();
            btn.innerText = "¡REGISTRADO!";
            // Opcional: Redirigir al login tras 2 segundos
            setTimeout(() => { window.location.href = 'login.php'; }, 2000);
        } else {
            btn.disabled = false;
            btn.innerText = "CREAR CUENTA";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.disabled = false;
        btn.innerText = "CREAR CUENTA";
    });
});
</script>

</body>
</html>