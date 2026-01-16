<?php
session_start();

use App\Entity\Usuario;

$entityManager = require_once __DIR__ . '/../src/Entity/bootstrap.php';
require_once __DIR__ . '/../src/Entity/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    $repo = $entityManager->getRepository(Usuario::class);
    $user = $repo->findOneBy(['usuario' => $usuario]);

    if ($user && password_verify($password, $user->getPass())) {

        $_SESSION['usuario'] = $user->getUsuario();

        echo json_encode([
            'status' => 'success',
            'mensaje' => "Bienvenido, " . $user->getNombre()
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'error',
            'mensaje' => 'Usuario o contraseña incorrectos'
        ]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login | El Corte Rebelde</title>

    <!-- 🔥 CSS EXTERNO -->
    <link rel="stylesheet" href="../src/Css/login.css">
</head>

<body>

    <div class="login-box">
        <div class="login-header">
            <img src="../src/img/logo_rebelde.png" alt="El Corte Rebelde">
        </div>

        <div class="login-body">

            <form id="form-login">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Tu usuario" required>

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Tu contraseña" required>

                <button type="submit" id="btn-login">Entrar</button>
            </form>

            <div id="respuesta-login"></div>

        </div>

        <div class="login-footer">
            ¿Nuevo en la tienda? <a href="registro.php">Crear cuenta</a>
        </div>
    </div>

    <script src="../src/Js/login.js"></script>

</body>
</html>
