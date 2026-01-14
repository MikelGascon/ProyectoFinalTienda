<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Luxury - El Corte Rebelde</title>
    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
            --negro: #000000;
            --gris-medio: #878686;
            --gris-claro: #D9D9D9;
        }

        body {
            margin: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #ffffff;
            height: 100vh; display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }

        /* Fondo decorativo */
        body::before {
            content: ""; position: fixed; top: -50%; left: -50%; width: 200%; height: 200%;
            background-image: url('../src/img/logo-rebelde.png'); background-repeat: repeat;
            background-size: 140px; opacity: 0.06; transform: rotate(-35deg); z-index: -1;
        }

        .login-box {
            background-color: #fff; border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); width: 420px; overflow: hidden;
        }

        .login-header {
            background: linear-gradient(to bottom, var(--marron-claro), var(--marron-oscuro));
            padding: 25px; text-align: center;
        }

        .login-header img { max-width: 160px; height: auto; }

        .login-body { padding: 30px 40px; background-color: var(--gris-claro); }

        .login-body label { display: block; margin-bottom: 5px; color: var(--negro); font-size: 0.8rem; font-weight: bold; text-transform: uppercase; }

        .login-body input {
            width: 100%; padding: 12px; margin-bottom: 15px;
            border: 1px solid var(--gris-medio); border-radius: 6px;
            box-sizing: border-box; font-size: 0.9rem;
        }

        .login-body button {
            width: 100%; padding: 14px; background-color: var(--marron-claro);
            color: #fff; border: none; border-radius: 6px; font-weight: bold;
            cursor: pointer; font-size: 1rem; transition: 0.3s;
        }

        .login-body button:hover { background-color: var(--marron-oscuro); }
        .login-body button:disabled { background-color: var(--gris-medio); cursor: not-allowed; }

        /* Mensajes AJAX */
        #respuesta {
            margin-top: 15px; padding: 12px; border-radius: 6px; 
            text-align: center; font-size: 0.9rem; display: none;
            font-weight: bold;
        }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .exito { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .login-footer {
            padding: 20px; background-color: #f9f9f9; text-align: center;
            font-size: 0.9rem; color: #666; border-top: 1px solid #eee;
        }
        .login-footer a { color: var(--marron-claro); text-decoration: none; font-weight: bold; }
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
            <input type="text" name="nombre" placeholder="Tu nombre" required>

            <label>Correo Electrónico</label>
            <input type="email" name="email" placeholder="email@ejemplo.com" required>

            <label>Usuario</label>
            <input type="text" name="usuario" placeholder="Nombre de usuario" required>

            <label>Contraseña</label>
            <input type="password" name="password" placeholder="••••••••" required>

            <label>Repetir Contraseña</label>
            <input type="password" name="confirm_password" placeholder="••••••••" required>

            <button type="submit" id="btn-enviar">CREAR CUENTA</button>
        </form>

        <div id="respuesta"></div>
    </div>

    <div class="login-footer">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </div>
</div>

<script>
document.getElementById('form-registro').addEventListener('submit', function(e) {
    e.preventDefault(); // Detener recarga de página

    const btn = document.getElementById('btn-enviar');
    const respuestaDiv = document.getElementById('respuesta');
    const formData = new FormData(this);

    // Feedback visual
    btn.disabled = true;
    btn.innerText = "PROCESANDO...";
    respuestaDiv.style.display = 'none';

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
            btn.innerText = "¡REGISTRO COMPLETADO!";
            // REDIRECCIÓN TRAS 1.5 SEGUNDOS
            setTimeout(() => {
                window.location.href = 'login.php'; 
            }, 1500);
        } else {
            btn.disabled = false;
            btn.innerText = "CREAR CUENTA";
        }
    })
    .catch(error => {
        btn.disabled = false;
        btn.innerText = "CREAR CUENTA";
        respuestaDiv.style.display = 'block';
        respuestaDiv.className = 'error';
        respuestaDiv.innerText = "Error en el servidor. Inténtalo de nuevo.";
    });
});
</script>

</body>
</html>