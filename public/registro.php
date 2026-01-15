<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="../src/Css/registro.css" rel="stylesheet">
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

    <script src="../src/Js/registro.js"></script>

</body>

</html>