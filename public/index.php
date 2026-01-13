<?php 
// index.php

// Cargamos la conexión desde el bootstrap
$conn = require_once '../src/BDD/bootstrap.php';

echo "<h1>Index de la aplicación</h1>";

try {
    // Obtenemos la conexión de Doctrine desde el EntityManager
    $conn = $entityManager->getConnection();
    
    // Intentamos conectar activamente
    $conn->connect();

    if ($conn->isConnected()) {
        echo "<p style='color: green;'> Conexión establecida correctamente vía Doctrine.</p>";
        echo "<ul>
                <li><strong>Base de datos:</strong> {$conn->getDatabase()}</li>
                <li><strong>Driver:</strong> " . get_class($conn->getDriver()) . "</li>
              </ul>";
    }
} catch (\Exception $e) {
    echo "<p style='color: red;'> Error al conectar: " . $e->getMessage() . "</p>";
}
