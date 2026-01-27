<?php
// Desactivar mostrar errores en la salida (para no romper el JSON)
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Iniciar buffer de salida para capturar cualquier output no deseado
ob_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Direcciones.php';
require_once __DIR__ . '/../Entity/Usuario.php';

use App\Entity\Direccion;
use App\Entity\Usuario;

// Limpiar cualquier output no deseado antes de continuar
ob_end_clean();

// Iniciar sesión solo si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que el usuario este logueado
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
    $usuario = $entityManager->find(Usuario::class, $usuario_id);
    
    if (!$usuario) {
        throw new Exception('Usuario no encontrado');
    }

    switch ($method) {
        case 'GET':
            handleGet($entityManager, $usuario_id);
            break;
            
        case 'POST':
            handlePost($entityManager, $usuario);
            break;
            
        case 'PUT':
            handlePut($entityManager, $usuario_id);
            break;
            
        case 'DELETE':
            handleDelete($entityManager, $usuario_id);
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

/* Obtener todas las direcciones*/
function handleGet($entityManager, $usuario_id) {
    try {
        $repo = $entityManager->getRepository(Direccion::class);
        $direcciones = $repo->findBy(['usuario' => $usuario_id]);
        
        $data = [];
        foreach ($direcciones as $dir) {
            $data[] = [
                'id' => $dir->getId(),
                'nombre' => $dir->getNombre(),
                'direccion' => $dir->getDireccion(),
                'ciudad' => $dir->getCiudad(),
                'provincia' => $dir->getProvincia(),
                'codigo_postal' => $dir->getCodigoPostal(),
                'pais' => $dir->getPais(),
                'telefono' => $dir->getTelefono(),
                'predeterminada' => $dir->isPredeterminada()
            ];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al obtener direcciones: ' . $e->getMessage()
        ]);
    }
}

/*Crear nueva dirección*/
function handlePost($entityManager, $usuario) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validar datos requeridos
        $required = ['nombre', 'direccion', 'ciudad', 'provincia', 'codigo_postal', 'pais', 'telefono'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => "El campo '{$field}' es obligatorio"
                ]);
                return;
            }
        }
        
        // Si se marca como predeterminada, quitar predeterminada de las demás
        if (!empty($data['predeterminada'])) {
            $repo = $entityManager->getRepository(Direccion::class);
            $direccionesActuales = $repo->findBy(['usuario' => $usuario->getId()]);
            
            foreach ($direccionesActuales as $dir) {
                if ($dir->isPredeterminada()) {
                    $dir->setPredeterminada(false);
                    $entityManager->persist($dir);
                }
            }
        }
        
        // Crear nueva dirección
        $direccion = new Direccion();
        $direccion->setUsuario($usuario);
        $direccion->setNombre($data['nombre']);
        $direccion->setDireccion($data['direccion']);
        $direccion->setCiudad($data['ciudad']);
        $direccion->setProvincia($data['provincia']);
        $direccion->setCodigoPostal($data['codigo_postal']);
        $direccion->setPais($data['pais']);
        $direccion->setTelefono($data['telefono']);
        $direccion->setPredeterminada($data['predeterminada'] ?? false);
        
        $entityManager->persist($direccion);
        $entityManager->flush();
        
        echo json_encode([
            'success' => true,
            'message' => 'Dirección creada correctamente',
            'data' => [
                'id' => $direccion->getId(),
                'nombre' => $direccion->getNombre(),
                'direccion' => $direccion->getDireccion(),
                'ciudad' => $direccion->getCiudad(),
                'provincia' => $direccion->getProvincia(),
                'codigo_postal' => $direccion->getCodigoPostal(),
                'pais' => $direccion->getPais(),
                'telefono' => $direccion->getTelefono(),
                'predeterminada' => $direccion->isPredeterminada()
            ]
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al crear dirección: ' . $e->getMessage()
        ]);
    }
}

/* Actualizar dirección existente*/
function handlePut($entityManager, $usuario_id) {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'ID de dirección requerido'
            ]);
            return;
        }
        
        $direccion = $entityManager->find(Direccion::class, $data['id']);
        
        if (!$direccion || $direccion->getUsuario()->getId() !== $usuario_id) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Dirección no encontrada'
            ]);
            return;
        }
        
        // Actualizar campos si están presentes
        if (isset($data['nombre'])) $direccion->setNombre($data['nombre']);
        if (isset($data['direccion'])) $direccion->setDireccion($data['direccion']);
        if (isset($data['ciudad'])) $direccion->setCiudad($data['ciudad']);
        if (isset($data['provincia'])) $direccion->setProvincia($data['provincia']);
        if (isset($data['codigo_postal'])) $direccion->setCodigoPostal($data['codigo_postal']);
        if (isset($data['pais'])) $direccion->setPais($data['pais']);
        if (isset($data['telefono'])) $direccion->setTelefono($data['telefono']);
        
        // Si se marca como predeterminada
        if (isset($data['predeterminada']) && $data['predeterminada']) {
            $repo = $entityManager->getRepository(Direccion::class);
            $todasDirecciones = $repo->findBy(['usuario' => $usuario_id]);
            
            foreach ($todasDirecciones as $dir) {
                if ($dir->isPredeterminada() && $dir->getId() !== $direccion->getId()) {
                    $dir->setPredeterminada(false);
                    $entityManager->persist($dir);
                }
            }
            
            $direccion->setPredeterminada(true);
        }
        
        $entityManager->persist($direccion);
        $entityManager->flush();
        
        echo json_encode([
            'success' => true,
            'message' => 'Dirección actualizada correctamente',
            'data' => [
                'id' => $direccion->getId(),
                'nombre' => $direccion->getNombre(),
                'predeterminada' => $direccion->isPredeterminada()
            ]
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar dirección: ' . $e->getMessage()
        ]);
    }
}

/*Eliminar dirección*/
function handleDelete($entityManager, $usuario_id) {
    try {
        // Obtener ID desde query string
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'ID de dirección requerido'
            ]);
            return;
        }
        
        $direccion = $entityManager->find(Direccion::class, $id);
        
        if (!$direccion || $direccion->getUsuario()->getId() !== $usuario_id) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Dirección no encontrada'
            ]);
            return;
        }
        
        // No permitir eliminar dirección predeterminada si hay otras
        if ($direccion->isPredeterminada()) {
            $repo = $entityManager->getRepository(Direccion::class);
            $totalDirecciones = count($repo->findBy(['usuario' => $usuario_id]));
            
            if ($totalDirecciones > 1) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'No puedes eliminar la dirección predeterminada. Establece otra como predeterminada primero.'
                ]);
                return;
            }
        }
        
        $entityManager->remove($direccion);
        $entityManager->flush();
        
        echo json_encode([
            'success' => true,
            'message' => 'Dirección eliminada correctamente'
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error al eliminar dirección: ' . $e->getMessage()
        ]);
    }
}