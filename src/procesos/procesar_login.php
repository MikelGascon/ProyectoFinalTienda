<?php
session_start();

use App\Entity\Usuario;

$entityManager = require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Usuario.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    $repo = $entityManager->getRepository(Usuario::class);
    $user = $repo->findOneBy(['usuario' => $usuario]);

    if ($user && password_verify($password, $user->getPassword())) {

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

echo json_encode([
    'status' => 'error',
    'mensaje' => 'Método no permitido'
]);
exit;