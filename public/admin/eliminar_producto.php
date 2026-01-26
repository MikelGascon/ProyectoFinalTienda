<?php
session_start();

// Verificar si está logueado como admin
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once '../../config/config.php';
$entityManager = require '../../src/Entity/bootstrap.php';
require_once '../../src/Entity/Producto.php';
require_once '../../src/Entity/Marcas.php';
require_once '../../src/Entity/TipoRopa.php';
require_once '../../src/Entity/TallaRopa.php';
require_once '../../src/Entity/CategoriaSexo.php';

use App\Entity\Producto;

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: dashboard.php?msg=ID de producto no válido&tipo=error');
    exit;
}

try {
    $producto = $entityManager->find(Producto::class, $id);
    
    if (!$producto) {
        header('Location: dashboard.php?msg=Producto no encontrado&tipo=error');
        exit;
    }
    
    // Eliminar el producto
    $entityManager->remove($producto);
    $entityManager->flush();
    
    header('Location: dashboard.php?msg=Producto eliminado correctamente&tipo=success');
    exit;
    
} catch (Exception $e) {
    header('Location: dashboard.php?msg=Error al eliminar el producto: ' . urlencode($e->getMessage()) . '&tipo=error');
    exit;
}
