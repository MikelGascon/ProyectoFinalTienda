<?php
/**
 * Endpoint: Cambiar Contraseña
 * Ruta: src/procesos/cambiar_password.php
 * Método: POST
 * Parámetros: current_password, new_password
 * 
 * NOTA: La validación de que el usuario ingresó correctamente su contraseña actual
 * dos veces se hace en el frontend. Aquí solo validamos una vez.
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

session_start();

header('Content-Type: application/json');

$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

$current_password = $_POST['current_password'] ?? null;
$new_password = $_POST['new_password'] ?? null;

if (!$current_password || !$new_password) {
    echo json_encode([
        'success' => false,
        'message' => 'Todos los campos son obligatorios'
    ]);
    exit;
}

// Validar longitud de la nueva contraseña
if (strlen($new_password) < 8) {
    echo json_encode([
        'success' => false,
        'message' => 'La nueva contraseña debe tener al menos 8 caracteres'
    ]);
    exit;
}

// Validar que la nueva contraseña sea diferente a la actual
if ($current_password === $new_password) {
    echo json_encode([
        'success' => false,
        'message' => 'La nueva contraseña debe ser diferente a la actual'
    ]);
    exit;
}

try {
    $conn = $entityManager->getConnection();
    
    // Obtener la contraseña actual del usuario
    $user = $conn->fetchAssociative(
        "SELECT password, nombre, email FROM usuarios WHERE id = ?",
        [$usuario_id]
    );
    
    if (!$user) {
        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ]);
        exit;
    }
    
    // Verificar contraseña actual
    if (!password_verify($current_password, $user['password'])) {
        // Registrar intento fallido
        try {
            $conn->executeStatement(
                "INSERT INTO logs_seguridad (usuario_id, accion, detalles, ip, fecha) 
                 VALUES (?, 'intento_cambio_password_fallido', 'Contraseña actual incorrecta', ?, NOW())",
                [$usuario_id, $_SERVER['REMOTE_ADDR'] ?? 'unknown']
            );
        } catch (Exception $e) {
            // Si la tabla no existe, continuar sin registrar
        }
        
        echo json_encode([
            'success' => false,
            'message' => 'La contraseña actual es incorrecta'
        ]);
        exit;
    }
    
    // Hash de la nueva contraseña
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Actualizar la contraseña
    $updated = $conn->executeStatement(
        "UPDATE usuarios SET password = ? WHERE id = ?",
        [$new_password_hash, $usuario_id]
    );
    
    if ($updated > 0) {
        // Opcional: Actualizar fecha de cambio de contraseña si existe el campo
        try {
            $conn->executeStatement(
                "UPDATE usuarios SET fecha_actualizacion_password = NOW() WHERE id = ?",
                [$usuario_id]
            );
        } catch (Exception $e) {
            // Si el campo no existe, continuar
        }
        
        // Registrar el cambio exitoso en log de seguridad
        try {
            $conn->executeStatement(
                "INSERT INTO logs_seguridad (usuario_id, accion, detalles, ip, user_agent, fecha) 
                 VALUES (?, 'cambio_password', 'Contraseña actualizada correctamente', ?, ?, NOW())",
                [$usuario_id, $_SERVER['REMOTE_ADDR'] ?? 'unknown', $_SERVER['HTTP_USER_AGENT'] ?? 'unknown']
            );
        } catch (Exception $e) {
            // Si la tabla no existe, continuar sin registrar
        }
        
        // Opcional: Enviar email de notificación
        /*
        $to = $user['email'];
        $subject = 'Cambio de contraseña - El Corte Rebelde';
        $message = "Hola {$user['nombre']},\n\n";
        $message .= "Tu contraseña ha sido cambiada exitosamente.\n";
        $message .= "Si no realizaste este cambio, contacta inmediatamente con soporte.\n\n";
        $message .= "Fecha: " . date('d/m/Y H:i:s') . "\n";
        $message .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n\n";
        $message .= "Saludos,\nEl Corte Rebelde";
        
        mail($to, $subject, $message);
        */
        
        echo json_encode([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo actualizar la contraseña'
        ]);
    }
    
} catch (Exception $e) {
    // Log del error
    error_log("Error al cambiar contraseña para usuario $usuario_id: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Error al cambiar la contraseña. Por favor, inténtalo de nuevo más tarde.'
    ]);
}