<?php
session_start();
require_once '../src/Entity/bootstrap.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$producto_id = $_GET['id'] ?? null;

if ($producto_id) {
    $conn = $entityManager->getConnection();

    // Comprobar si ya existe
    $sqlCheck = "SELECT id FROM favoritos WHERE usuario_id = :u AND producto_id = :p";
    $existe = $conn->fetchOne($sqlCheck, ['u' => $usuario_id, 'p' => $producto_id]);

    if ($existe) {
        // SI EXISTE: Lo quitamos (borrar)
        $conn->executeStatement("DELETE FROM favoritos WHERE id = :id", ['id' => $existe]);
    } else {
        // SI NO EXISTE: Lo añadimos (insertar)
        $conn->executeStatement("INSERT INTO favoritos (usuario_id, producto_id) VALUES (:u, :p)", [
            'u' => $usuario_id,
            'p' => $producto_id
        ]);
    }
}

// Retorno dinámico a la página anterior
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: filtro.php");
}
exit();