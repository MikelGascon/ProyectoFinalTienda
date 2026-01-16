<?php
require_once __DIR__ . '/../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="<?php echo BASE_URL . CSS_URL; ?>/registro.css">
</head>

<body>

    <div class="login-box">

        <div class="login-header">
            <img src="<?php echo BASE_URL . IMG_URL?>/logo-rebelde.png" alt="El Corte Rebelde">
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
    
    <script src="<?php echo BASE_URL . JS_URL; ?>/registro.js"></script>

</body>

</html>