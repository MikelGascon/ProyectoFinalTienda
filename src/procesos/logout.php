<?php
session_start();

// Guardar usuario_id antes de destruir sesión (para limpiar tokens)
$usuarioId = $_SESSION['usuario_id'] ?? null;

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la cookie de sesión
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

if (isset($_COOKIE['usuario_id'])) {
    setcookie('usuario_id', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

// SI USAS LA VERSIÓN SEGURA: Eliminar tokens de la base de datos
if ($usuarioId !== null) {
    try {
        $entityManager = require_once __DIR__ . '/../Entity/bootstrap.php';
        $connection = $entityManager->getConnection();
        
        $sql = "DELETE FROM remember_tokens WHERE usuario_id = :usuario_id";
        $stmt = $connection->prepare($sql);
        $stmt->executeStatement(['usuario_id' => $usuarioId]);
        
    } catch (Exception $e) {
        error_log("Error al eliminar tokens: " . $e->getMessage());
    }
}

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio
header("Location: ../../public/index.php");
exit;