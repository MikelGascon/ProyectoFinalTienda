<?php
use App\Entity\Usuario;

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay cookie de "recordarme" y no hay sesión activa
if (!isset($_SESSION['logueado']) && isset($_COOKIE['remember_token']) && isset($_COOKIE['usuario_id'])) {
    
    try {
        // Cargar EntityManager y Usuario
        $entityManager = require_once __DIR__ . '/../Entity/bootstrap.php';
        require_once __DIR__ . '/../Entity/Usuario.php';
        
        $userId = (int) $_COOKIE['usuario_id'];
        
        // Obtener usuario desde la base de datos
        $repo = $entityManager->getRepository(Usuario::class);
        $user = $repo->find($userId);
        
        // Si el usuario existe, restaurar la sesión
        if ($user) {
            // IMPORTANTE: En producción, deberías verificar el token contra la BD
            // Aquí asumo que si existe la cookie es válida
            // En producción: verificar que el token coincida con el hasheado en la BD
            
            $_SESSION['usuario_id'] = $user->getId();
            $_SESSION['usuario'] = $user->getUsuario();
            $_SESSION['nombre'] = $user->getNombre();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['logueado'] = true;
        } else {
            // Usuario no encontrado, eliminar cookies inválidas
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
            setcookie('usuario_id', '', time() - 3600, '/', '', true, true);
        }
        
    } catch (Exception $e) {
        // En caso de error, simplemente no restaurar la sesión
        error_log("Error al restaurar sesión desde cookie: " . $e->getMessage());
    }
}

// Variables globales para usar en todo el sitio
$usuarioLogueado = isset($_SESSION['logueado']) && $_SESSION['logueado'] === true;
$nombreUsuario = $_SESSION['nombre'] ?? 'Invitado';
$usuario = $_SESSION['usuario'] ?? '';
$emailUsuario = $_SESSION['email'] ?? '';
$usuarioId = $_SESSION['usuario_id'] ?? null;