<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login | El Corte Rebelde</title>
    <link rel="stylesheet" href="<?php echo BASE_URL . CSS_URL; ?>/login.css">
</head>

<body>

    <div class="login-box">
        <div class="login-header">
            <img src="<?php echo BASE_URL . IMG_URL ?>/logo_rebelde.png" alt="El Corte Rebelde">
        </div>

        <div class="login-body">

            <form id="form-login">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Tu usuario" required>

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Tu contraseña" autocomplete="off"
                    required>
                <button type="submit" id="btn-login">Entrar</button>
            </form>

            <div id="respuesta-login"></div>

        </div>

        <div class="login-footer">
            ¿Nuevo en la tienda? <a href="registro.php">Crear cuenta</a>
        </div>
    </div>

    <script src="<?php echo BASE_URL . JS_URL; ?>/login.js"></script>

</body>

</html>