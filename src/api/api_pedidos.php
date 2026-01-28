<?php
/*API REST para Pedidos*/
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Pedido.php';

use App\Entity\Pedido;

session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'No autorizado. Debes iniciar sesión.'
    ]);
    exit;
}

$usuario_id = (int)$_SESSION['usuario_id'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        handleGet($entityManager, $usuario_id);
    } else {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}

/*Obtener todos los pedidos*/

function handleGet($entityManager, $usuario_id) {
    $repo = $entityManager->getRepository(Pedido::class);
    $pedidos = $repo->findBy(
        ['usuario' => $usuario_id],
        ['fecha' => 'DESC'] // Ordenar por fecha descendente
    );
    
    $data = [];
    $totalGastado = 0;
    
    foreach ($pedidos as $pedido) {
        $precio = (float)$pedido->getPrecio();
        $cantidad = $pedido->getCantidadProductos();
        $subtotal = $precio * $cantidad;
        $totalGastado += $subtotal;
        
        $data[] = [
            'id' => $pedido->getId(),
            'nombre' => $pedido->getNombre(),
            'precio' => number_format($precio, 2),
            'cantidad' => $cantidad,
            'subtotal' => number_format($subtotal, 2),
            'fecha' => $pedido->getFecha()->format('Y-m-d H:i:s'),
            'fecha_formateada' => $pedido->getFecha()->format('d/m/Y H:i')
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data,
        'total_pedidos' => count($pedidos),
        'total_gastado' => number_format($totalGastado, 2)
    ]);
}