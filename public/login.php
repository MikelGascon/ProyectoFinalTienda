<?php
session_start();

// Si ya está logueado, lo mandamos al index directamente
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Manejo de Logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. CONEXIÓN A LA BASE DE DATOS
    $conexion = new mysqli("localhost", "root", "root", "app_tienda");

    if ($conexion->connect_error) {
        die("Error de conexión");
    }

    $usuario_ingresado = $conexion->real_escape_string($_POST['usuario']);
    $password_ingresada = $_POST['password'];

    // 2. BUSCAR AL USUARIO EN LA BASE DE DATOS
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario_ingresado'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows === 1) {
        $datos_usuario = $resultado->fetch_assoc();
        
        // 3. VERIFICAR CONTRASEÑA ENCRIPTADA
        if (password_verify($password_ingresada, $datos_usuario['password'])) {
            // ÉXITO: Creamos la sesión y redirigimos
            $_SESSION['usuario'] = $datos_usuario['usuario'];
            $_SESSION['nombre'] = $datos_usuario['nombre']; // Guardamos el nombre real también
            
            header("Location: index.php");
            exit;
        } else {
            $mensaje = 'Contraseña incorrecta';
        }
    } else {
        $mensaje = 'El usuario no existe';
    }
    
    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Luxury - El Corte Rebelde</title>
    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
            --negro: #000000;
            --gris-medio: #878686;
            --gris-claro: #D9D9D9;
        }

        body {
            margin: 0; font-family: Arial, sans-serif; background-color: #ffffff;
            height: 100vh; display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }

        body::before {
            content: ""; position: fixed; top: -50%; left: -50%; width: 200%; height: 200%;
            background-image: url('../src/img/logo-rebelde.png'); background-repeat: repeat;
            background-size: 140px; opacity: 0.08; transform: rotate(-35deg); z-index: -1;
        }

        .login-box {
            background-color: #fff; border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18); width: 420px; overflow: hidden;
        }

        .login-header {
            background: linear-gradient(to bottom, var(--marron-claro), var(--marron-oscuro));
            padding: 30px 20px; text-align: center;
        }

        .login-header img { max-width: 170px; height: auto; display: block; margin: 0 auto; }

        .login-body { padding: 35px 40px; background-color: var(--gris-claro); }

        .login-body label { display: block; margin-bottom: 6px; color: var(--negro); font-size: 0.9rem; font-weight: bold; }

        .login-body input {
            width: 100%; padding: 12px; margin-bottom: 18px;
            border: 1px solid var(--gris-medio); border-radius: 6px;
            box-sizing: border-box; font-size: 1rem;
        }

        .login-body button {
            width: 100%; padding: 12px; background-color: var(--marron-claro);
            color: #fff; border: none; border-radius: 6px; font-weight: bold;
            cursor: pointer; font-size: 1rem;
        }

        .login-body button:hover { background-color: #7e7661ff; }

        .mensaje {
            margin-top: 12px; color: #b00020; font-size: 0.9rem;
            text-align: center; font-weight: bold;
        }

        .login-footer {
            padding: 18px; background-color: #f7f7f7; text-align: center;
            font-size: 0.9rem; color: var(--gris-medio);
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
            <form method="post">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Tu nombre de usuario" required>

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Tu contraseña" required>

                <button type="submit">ENTRAR</button>
            </form>

            <?php if ($mensaje): ?>
                <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php endif; ?>
        </div>

        <div class="login-footer">
            ¿Nuevo en la tienda? <a href="registro.php">Crear cuenta</a>
        </div>
    </div>
</body>
</html>