<?php
session_start();

$mensaje = '';
$registro_exitoso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        $mensaje = 'Las contraseñas no coinciden';
    } else {
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);
        
        $mensaje = "¡Bienvenido/a, $nombre!";
        $registro_exitoso = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - El Corte Rebelde</title>
    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
            --negro: #000000;
            --gris-medio: #878686;
            --gris-claro: #D9D9D9;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background-image: url('../src/img/logo-rebelde.png');
            background-repeat: repeat;
            background-size: 140px;
            opacity: 0.08;
            transform: rotate(-35deg);
            z-index: -1;
        }

        .login-box {
            background-color: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18);
            width: 420px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(to bottom, var(--marron-claro), var(--marron-oscuro));
            padding: 20px 20px;
            text-align: center;
        }

        .login-header img {
            max-width: 150px;
            height: auto;
            display: block;
            margin: 0 auto 5px;
        }

        .login-body {
            padding: 25px 40px;
            background-color: var(--gris-claro);
        }

        .login-body label {
            display: block;
            margin-bottom: 4px;
            color: var(--negro);
            font-size: 0.9rem;
        }

        .login-body input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid var(--gris-medio);
            border-radius: 6px;
            background-color: #fff;
            color: var(--negro);
            font-size: 0.9rem;
            box-sizing: border-box;
        }

        .login-body input:focus {
            border-color: var(--marron-claro);
            outline: none;
            box-shadow: 0 0 0 2px #AAA085;
        }

        .login-body button {
            width: 100%;
            padding: 12px;
            background-color: var(--marron-claro);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 5px;
        }

        .login-body button:hover {
            background-color: #7e7661ff;
        }

        .mensaje {
            margin-top: 12px;
            color: #b00020;
            font-size: 0.9rem;
            text-align: center;
        }

        .bienvenida {
            margin-top: 12px;
            color: var(--marron-claro);
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
        }

        .login-footer {
            padding: 18px;
            background-color: #f7f7f7;
            text-align: center;
            font-size: 0.9rem;
            color: var(--gris-medio);
        }

        .login-footer a {
            color: var(--marron-claro);
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <div class="login-header">
            <img src="../src/img/logo-rebelde.png" alt="El Corte Rebelde">
        </div>

        <div class="login-body">
            <?php if (!$registro_exitoso): ?>
                <form method="post">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="ejemplo@correo.com" required 
                           style="width: 100%; padding: 10px; margin-bottom: 12px; border: 1px solid var(--gris-medio); border-radius: 6px;">

                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Nombre de usuario" required>

                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Mínimo 6 caracteres" required>

                    <label for="confirm_password">Repetir Contraseña</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirma tu contraseña" required>

                    <button type="submit">Crear Cuenta</button>
                </form>

                <?php if ($mensaje): ?>
                    <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
                <?php endif; ?>

            <?php else: ?>
                <div class="bienvenida"><?php echo htmlspecialchars($mensaje); ?></div>
                <p style="text-align:center;">Tu cuenta ha sido creada correctamente con seguridad de encriptado.</p>
                
                <a href="login.php" style="text-decoration: none;">
                    <button type="button">Ir al inicio de sesión</button>
                </a>
            <?php endif; ?>
        </div>

        <div class="login-footer">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </div>
</body>

</html>