<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../src/bootstrap.php';

require_once '../src/Entity/Producto.php';
require_once '../src/Entity/Marcas.php';
require_once '../src/Entity/TipoRopa.php';
require_once '../src/Entity/TallaRopa.php';
require_once '../src/Entity/CategoriaSexo.php';

require_once '../src/Entity/Producto.php';
require_once '../src/Entity/Marcas.php';
require_once '../src/Entity/TipoRopa.php';
require_once '../src/Entity/TallaRopa.php';
require_once '../src/Entity/CategoriaSexo.php';
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