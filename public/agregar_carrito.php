<?php
session_start();
require_once '../config/config.php';
require_once ENTITY_PATH . DIRECTORY_SEPARATOR . 'bootstrap.php';
use App\Entity\Producto;

$id = $_GET['id'] ?? null;

if ($id) {
    $producto = $entityManager->find(Producto::class, $id);
    if ($producto) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Guardamos el ID, nombre (para la imagen) y precio
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id] = [
                'nombre' => $producto->getNombre(),
                'precio' => $producto->getPrecio(),
                'cantidad' => 1
            ];
        }
    }
}
header('Location: carrito.php');
exit;