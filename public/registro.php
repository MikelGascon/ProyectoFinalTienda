<?php
session_start();

$mensaje = '';
$registro_exitoso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // En un sistema real, aquí conectarías a la base de datos
    $usuario = $_POST['usuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Lógica básica de validación
    if ($password !== $confirm_password) {
        $mensaje = 'Las contraseñas no coinciden';
    } elseif (strlen($password) < 6) {
        $mensaje = 'La contraseña debe tener al menos 6 caracteres';
    } else {
        // Aquí iría la inserción en la base de datos (INSERT INTO...)
        $registro_exitoso = true;
        $mensaje = "¡Cuenta creada con éxito para $usuario!";
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
            padding: 25px 20px;
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
            font-weight: bold;
        }

        .login-body input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
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
            margin-top: 10px;
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

        .exito {
            color: #2e7d32;
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
            <h2 style="color: white; margin: 0; font-size: 1.2rem;">Crear Cuenta</h2>
        </div>

        <div class="login-body">
            <?php if (!$registro_exitoso): ?>
                <form method="post">
                    <label for="usuario">Nombre de Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Ej: Usuario12" required>

                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" placeholder="correo@ejemplo.com" required 
                           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid var(--gris-medio); border-radius: 6px;">

                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Mínimo 6 caracteres" required>

                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Repite tu contraseña" required>

                    <button type="submit">Registrarse</button>
                </form>

                <?php if ($mensaje): ?>
                    <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
                <?php endif; ?>

            <?php else: ?>
                <div class="exito"><?php echo htmlspecialchars($mensaje); ?></div>
                <p style="text-align:center;">Ya puedes acceder a tu cuenta.</p>
                <a href="login.php" style="text-decoration:none;">
                    <button type="button">Ir al Inicio de Sesión</button>
                </a>
            <?php endif; ?>
        </div>

        <div class="login-footer">
            ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
    </div>
</body>

</html>