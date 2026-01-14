<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['logout'])) {
    $usuario_valido = 'cliente';
    $password_valida = 'ropa123';

    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario === $usuario_valido && $password === $password_valida) {
        $_SESSION['usuario'] = $usuario;
        $mensaje = "Bienvenido, $usuario";
    } else {
        $mensaje = 'Usuario o contraseña incorrectos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
            background-image: url('../src/img/logo_rebelde.png');
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
            padding: 30px 20px;
            text-align: center;
        }

        .login-header img {
            max-width: 170px;
            height: auto;
            display: block;
            margin: 0 auto 5px;
        }

        .login-body {
            padding: 35px 40px;
            background-color: var(--gris-claro);
        }

        .login-body label {
            display: block;
            margin-bottom: 6px;
            color: var(--negro);
            font-size: 1rem;
        }

        .login-body input[type="text"],
        .login-body input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid var(--gris-medio);
            border-radius: 6px;
            background-color: #fff;
            color: var(--negro);
            font-size: 1rem;
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
            color: #ffffffc5;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
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
            font-size: 1rem;
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
            <img src="../src/img/logo_rebelde.png" alt="El Corte Rebelde">
        </div>

        <div class="login-body">
            <?php if (!isset($_SESSION['usuario'])): ?>
                <form method="post">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Tu nombre de usuario - Usuario12" required>

                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Tu contraseña - Contraseña1234" required>

                    <button type="submit">Entrar</button>
                </form>

                <?php if ($mensaje): ?>
                    <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
                <?php endif; ?>

            <?php else: ?>
                <div class="bienvenida"><?php echo htmlspecialchars($mensaje); ?></div>
                <p style="text-align:center;">Catálogo disponible próximamente.</p>

                <form method="post">
                    <button type="submit" name="logout">Cerrar sesión</button>
                </form>
            <?php endif; ?>
        </div>

        <div class="login-footer">
            ¿Nuevo en la tienda? <a href="registro.php">Crear cuenta</a>
        </div>
    </div>
</body>

</html>
