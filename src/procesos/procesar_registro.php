<?php
use App\Entity\Usuario;

$entityManager = require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Usuario.php';
header('Content-Type: application/json');

// 3. CAPTURA Y VALIDACIÓN DE DATOS
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (empty($nombre) || empty($email) || empty($usuario) || empty($password)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Por favor, rellena todos los campos']);
    exit;
}

if (strlen($password) < 3) {
    echo json_encode(['status' => 'error', 'mensaje' => 'La contraseña debe tener al menos 6 caracteres']);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Las contraseñas no coinciden']);
    exit;
}

// 4. PERSISTENCIA CON DOCTRINE
try {

    $nuevo = new Usuario();
    $nuevo->setNombre($nombre);
    $nuevo->setEmail($email);
    $nuevo->setUsuario($usuario);
    $nuevo->setPassword(password_hash($password, PASSWORD_DEFAULT));

    $entityManager->persist($nuevo);
    $entityManager->flush();

    echo json_encode(['status' => 'success', 'mensaje' => '¡Registro completado con éxito!']);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}

?>