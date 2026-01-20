<?php
session_start();
require_once '../config/config.php';
require_once '../src/Entity/bootstrap.php';

require_once '../src/Entity/Producto.php';
require_once '../src/Entity/Marcas.php';
require_once '../src/Entity/TipoRopa.php';
require_once '../src/Entity/TallaRopa.php';
require_once '../src/Entity/CategoriaSexo.php';
use App\Entity\Producto;

$id = $_GET['id'] ?? null;

if ($id) {
    // Usamos Doctrine para encontrar el producto por su ID
    $producto = $entityManager->find(Producto::class, $id);

    if ($producto) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si ya existe, aumentamos cantidad, si no, lo creamos
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