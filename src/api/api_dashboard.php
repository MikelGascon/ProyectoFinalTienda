<?php
// Desactivar mostrar errores en la salida (para no romper el JSON)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Iniciar buffer de salida para capturar cualquier output no deseado
ob_start();

/**
 * API REST para Dashboard del Perfil
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Usuario.php';
require_once __DIR__ . '/../Entity/TarjetaRegalo.php';

use App\Entity\Usuario;
use App\Entity\TarjetaRegalo;

// Limpiar cualquier output no deseado antes de continuar
ob_end_clean();

// Iniciar sesión solo si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
        'message' => 'Error del servidor: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

/*Obtener datos del dashboard*/
function handleGet($entityManager, $usuario_id) {
    try {
        // Cargar usuario
        $usuario = $entityManager->find(Usuario::class, $usuario_id);
        
        if (!$usuario) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
            return;
        }
        
        // Obtener conexión para consultas directas
        $conn = $entityManager->getConnection();
        
        // Contar favoritos
        $totalFavoritos = $conn->fetchOne(
            "SELECT COUNT(*) FROM favoritos WHERE usuario_id = ?",
            [$usuario_id]
        );
        
        // Contar pedidos
        $totalPedidos = $conn->fetchOne(
            "SELECT COUNT(*) FROM pedido WHERE usuario_id = ?",
            [$usuario_id]
        );
        
        // Obtener tarjetas regalo usando ORM
        $repoTarjetas = $entityManager->getRepository(TarjetaRegalo::class);
        $misTarjetas = $repoTarjetas->findBy(
            ['usuario' => $usuario_id],
            ['fechaCompra' => 'DESC']
        );
        
        //Transformar tarjetas a array
        $tarjetasData = [];
        foreach ($misTarjetas as $tarjeta) {
            $tarjetasData[] = [
                'codigo' => $tarjeta->getCodigo(),
                'importe' => number_format((float)$tarjeta->getImporte(), 2, '.', ''),
                'mensaje' => $tarjeta->getMensaje() ?: 'Sin mensaje',
                'fecha_compra' => $tarjeta->getFechaCompra()->format('Y-m-d H:i:s'),
                'fecha_formateada' => $tarjeta->getFechaCompra()->format('d/m/Y')
            ];
        }
        
        // Responder con todos los datos
        echo json_encode([
            'success' => true,
            'data' => [
                'usuario' => [
                    'id' => $usuario->getId(),
                    'nombre' => $usuario->getNombre(),
                    'usuario' => $usuario->getUsuario(),
                    'email' => $usuario->getEmail()
                ],
                'stats' => [
                    'pedidos' => (int)$totalPedidos,
                    'favoritos' => (int)$totalFavoritos,
                    'tarjetas_regalo' => count($misTarjetas)
                ],
                'tarjetas' => $tarjetasData
            ]
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al obtener datos del dashboard: ' . $e->getMessage()
        ]);
    }
}