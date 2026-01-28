<?php

use Doctrine\ORM\EntityManager;
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
header('Access-Control-Allow-Methods: GET, PUT, POST');
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

$usuario_id = (int) $_SESSION['usuario_id'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    $usuario = $entityManager->find(Usuario::class, $usuario_id);
    if (!$usuario) {
        throw new Exception("Usuario no encontrado");

    }

    switch ($method) {
        case 'GET':
            handleGet($entityManager, $usuario_id);
            break;
        case 'PUT':
            handlePut($entityManager, $usuario_id);
            break;
    }


} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

/*Obtener datos del dashboard*/
function handleGet($entityManager, $usuario_id)
{
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
                'importe' => number_format((float) $tarjeta->getImporte(), 2, '.', ''),
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
                    'pedidos' => (int) $totalPedidos,
                    'favoritos' => (int) $totalFavoritos,
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

//Actualizar los datos del usuario
function handlePut($entityManager, $usuario_id)
{
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            throw new Exception("No se recibieron datos válidos");
        }

        $usuario = $entityManager->find(Usuario::class, $usuario_id);

        if (!$usuario) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            return;
        }

        // 1. Actualizar los campos en la entidad
        if(isset($data['nombre'])) {
            $usuario->setNombre($data['nombre']);
            // ACTUALIZAR SESIÓN
            $_SESSION['nombre'] = $data['nombre']; 
        }
        
        if(isset($data['usuario'])) {
            $usuario->setUsuario($data['usuario']);
            // ACTUALIZAR SESIÓN
            $_SESSION['usuario'] = $data['usuario'];
        }
        
        if(isset($data['email'])) {
            $usuario->setEmail($data['email']);
            // Si guardas el email en sesión, actualízalo también
            $_SESSION['email'] = $data['email'];
        }
        
        // 2. Guardar en Base de Datos
        $entityManager->flush();

        // 3. Responder
        echo json_encode([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => [
                'id' => $usuario->getId(),
                'usuario' => $usuario->getUsuario(),
                'nombre' => $usuario->getNombre(),
                'email' => $usuario->getEmail()
            ]
        ]);

    } catch (Exception $ex) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar: ' . $ex->getMessage()
        ]);
    }
}
