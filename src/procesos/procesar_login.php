<?php
use App\Entity\Usuario;

session_start();

$entityManager = require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Usuario.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $recordar = isset($_POST['recordar']) && $_POST['recordar'] === 'on';

    if ($usuario === 'admin' && $password === 'admin') {
        $_SESSION['admin_logueado'] = true;
        $_SESSION['admin_usuario'] = 'admin';
        $_SESSION['logueado'] = true;
        
        echo json_encode([
            'status' => 'success',
            'mensaje' => "Bienvenido, Administrador",
            'redirect' => 'admin/dashboard.php'
        ]);
        exit;
    }

    $repo = $entityManager->getRepository(Usuario::class);
    $user = $repo->findOneBy(['usuario' => $usuario]);

    if ($user && password_verify($password, $user->getPassword())) {

        $_SESSION['usuario_id'] = $user->getId();
        $_SESSION['usuario'] = $user->getUsuario();
        $_SESSION['nombre'] = $user->getNombre();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['logueado'] = true;

        if ($recordar) {
            $expiracion = time() + (86400 * 30); // 30 días
            setcookie('usuario_id', $user->getId(), ['expires' => $expiracion, 'path' => '/', 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
        }


        echo json_encode([
            'status' => 'success',
            'mensaje' => "Bienvenido, " . $user->getNombre(),
            'redirect' => 'index.php'
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

echo json_encode([
    'status' => 'error',
    'mensaje' => 'Método no permitido'
]);
exit;