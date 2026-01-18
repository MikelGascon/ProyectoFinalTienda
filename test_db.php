<?php
use App\Entity\Usuario;
/**
 * TEST DE CONEXIÓN A BASE DE DATOS
 * 
 * Usa este archivo para verificar que Doctrine está funcionando correctamente
 * Accede a: http://localhost/tu-proyecto/test_db.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Test de Conexión a Base de Datos</h1>";
echo "<hr>";

// 1. Verificar que bootstrap.php existe
echo "<h2>1. Verificando bootstrap.php</h2>";
$bootstrapPath = __DIR__ . '/src/Entity/bootstrap.php';
if (file_exists($bootstrapPath)) {
    echo "✅ Archivo bootstrap.php encontrado en: $bootstrapPath<br>";
} else {
    echo "❌ ERROR: No se encuentra bootstrap.php en: $bootstrapPath<br>";
    exit;
}

// 2. Cargar EntityManager
echo "<h2>2. Cargando EntityManager</h2>";
try {
    $entityManager = require_once $bootstrapPath;
    echo "✅ EntityManager cargado correctamente<br>";
} catch (Exception $e) {
    echo "❌ ERROR al cargar EntityManager: " . $e->getMessage() . "<br>";
    exit;
}

// 3. Verificar clase Usuario
echo "<h2>3. Verificando clase Usuario</h2>";
$usuarioPath = __DIR__ . '/src/Entity/Usuario.php';
if (file_exists($usuarioPath)) {
    echo "✅ Archivo Usuario.php encontrado<br>";
    require_once $usuarioPath;
    
    if (class_exists('App\Entity\Usuario')) {
        echo "✅ Clase Usuario cargada correctamente<br>";
    } else {
        echo "❌ ERROR: La clase Usuario no existe<br>";
    }
} else {
    echo "❌ ERROR: No se encuentra Usuario.php en: $usuarioPath<br>";
}

// 4. Probar conexión a BD
echo "<h2>4. Probando conexión a la base de datos</h2>";
try {
    $conn = $entityManager->getConnection();
    $conn->executeQuery('SELECT 1');
    echo "✅ Conexión a la base de datos exitosa<br>";
} catch (Exception $e) {
    echo "❌ ERROR de conexión: " . $e->getMessage() . "<br>";
}

// 5. Contar usuarios existentes
echo "<h2>5. Consultando tabla de usuarios</h2>";
try {
    
    $usuarios = $entityManager->getRepository(Usuario::class)->findAll();
    $total = count($usuarios);
    
    echo "✅ Se encontraron <strong>$total usuarios</strong> en la base de datos<br>";
    
    if ($total > 0) {
        echo "<h3>Usuarios registrados:</h3>";
        echo "<ul>";
        foreach ($usuarios as $user) {
            echo "<li>" . $user->getUsuario() . " (" . $user->getEmail() . ")</li>";
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR al consultar usuarios: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>✅ Test completado</h2>";
echo "<p>Si todos los checks son ✅, la conexión está funcionando correctamente.</p>";
?>