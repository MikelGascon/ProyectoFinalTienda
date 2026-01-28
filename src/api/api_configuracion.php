<?php
// Desactivar mostrar errores en la salida (para no romper el JSON)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Iniciar buffer de salida para capturar cualquier output no deseado
ob_start();

/* API REST para Gestión del Perfil de Usuario*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Usuario.php';

use App\Entity\Usuario;

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

// Manejar POST para cambio de contraseña
if ($method === 'POST') {
    $action = $_GET['action'] ?? '';
    if ($action === 'cambiar_password') {
        handleCambiarPassword($entityManager, $usuario_id);
        exit;
    }
}

try {
    switch ($method) {
        case 'GET':
            handleGet($entityManager, $usuario_id);
            break;
            
        case 'PUT':
            handlePut($entityManager, $usuario_id);
            break;
            
        default:
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

/*GET - Obtener datos del usuario*/
function handleGet($entityManager, $usuario_id) {
    $usuario = $entityManager->find(Usuario::class, $usuario_id);
    
    if (!$usuario) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ]);
        return;
    }
    
    // Obtener estadísticas
    $conn = $entityManager->getConnection();
    
    $totalPedidos = $conn->fetchOne(
        "SELECT COUNT(*) FROM pedido WHERE usuario_id = ?",
        [$usuario_id]
    );
    
    $totalFavoritos = $conn->fetchOne(
        "SELECT COUNT(*) FROM favoritos WHERE usuario_id = ?",
        [$usuario_id]
    );
    
    $totalTarjetas = $conn->fetchOne(
        "SELECT COUNT(*) FROM tarjetas_regalo WHERE usuario_id = ?",
        [$usuario_id]
    );
    
    echo json_encode([
        'success' => true,
        'data' => [
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'usuario' => $usuario->getUsuario(),
            'email' => $usuario->getEmail(),
            'stats' => [
                'pedidos' => $totalPedidos,
                'favoritos' => $totalFavoritos,
                'tarjetas_regalo' => $totalTarjetas
            ]
        ]
    ]);
}

/* Actualizar datos del usuario*/
function handlePut($entityManager, $usuario_id) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $usuario = $entityManager->find(Usuario::class, $usuario_id);
        
        if (!$usuario) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
            return;
        }
        
        // Validar email si se está actualizando
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Email inválido'
            ]);
            return;
        }
        
        // Verificar si el email ya está en uso por otro usuario
        if (isset($data['email']) && $data['email'] !== $usuario->getEmail()) {
            $repo = $entityManager->getRepository(Usuario::class);
            $usuarioConEmail = $repo->findOneBy(['email' => $data['email']]);
            
            if ($usuarioConEmail && $usuarioConEmail->getId() !== $usuario_id) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'El email ya está registrado'
                ]);
                return;
            }
        }
        
        // Verificar si el nombre de usuario ya está en uso
        if (isset($data['usuario']) && $data['usuario'] !== $usuario->getUsuario()) {
            $repo = $entityManager->getRepository(Usuario::class);
            $usuarioExistente = $repo->findOneBy(['usuario' => $data['usuario']]);
            
            if ($usuarioExistente && $usuarioExistente->getId() !== $usuario_id) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'El nombre de usuario ya está en uso'
                ]);
                return;
            }
        }
        
        // Actualizar campos
        if (isset($data['nombre'])) {
            $usuario->setNombre($data['nombre']);
            $_SESSION['nombre'] = $data['nombre'];
        }
        
        if (isset($data['usuario'])) {
            $usuario->setUsuario($data['usuario']);
            $_SESSION['usuario'] = $data['usuario'];
        }
        
        if (isset($data['email'])) {
            $usuario->setEmail($data['email']);
            $_SESSION['email'] = $data['email'];
        }
        
        $entityManager->persist($usuario);
        $entityManager->flush();
        
        echo json_encode([
            'success' => true,
            'message' => 'Perfil actualizado correctamente',
            'data' => [
                'nombre' => $usuario->getNombre(),
                'usuario' => $usuario->getUsuario(),
                'email' => $usuario->getEmail()
            ]
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar perfil: ' . $e->getMessage()
        ]);
    }
}

/* Cambiar contraseña*/
function handleCambiarPassword($entityManager, $usuario_id) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validar datos requeridos
    if (empty($data['password_actual']) || empty($data['password_nueva'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Contraseña actual y nueva son requeridas'
        ]);
        return;
    }
    
    $usuario = $entityManager->find(Usuario::class, $usuario_id);
    
    if (!$usuario) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ]);
        return;
    }
    
    // Verificar contraseña actual
    if (!password_verify($data['password_actual'], $usuario->getPassword())) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'La contraseña actual es incorrecta'
        ]);
        return;
    }
    
    // Validar longitud de la nueva contraseña
    if (strlen($data['password_nueva']) < 6) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'La nueva contraseña debe tener al menos 6 caracteres'
        ]);
        return;
    }
    
    // Actualizar contraseña
    $passwordHash = password_hash($data['password_nueva'], PASSWORD_DEFAULT);
    $usuario->setPassword($passwordHash);
    
    $entityManager->persist($usuario);
    $entityManager->flush();
    
    echo json_encode([
        'success' => true,
        'message' => 'Contraseña actualizada correctamente'
    ]);
}