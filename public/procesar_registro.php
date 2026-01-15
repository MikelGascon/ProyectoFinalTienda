<?php
// Desactivar visualización de errores HTML para no romper el JSON, 
// pero registrarlos en el servidor
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "root";
$db   = "app_tienda";

try {
    $conexion = new mysqli($host, $user, $pass, $db);

    if ($conexion->connect_error) {
        throw new Exception("Error de conexión a la base de datos");
    }

    // Validar que lleguen los datos
    if (!isset($_POST['usuario'], $_POST['password'], $_POST['nombre'], $_POST['email'])) {
        throw new Exception("Faltan datos en el formulario");
    }

    $nombre   = $conexion->real_escape_string($_POST['nombre']);
    $email    = $conexion->real_escape_string($_POST['email']);
    $usuario  = $conexion->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        throw new Exception("Las contraseñas no coinciden");
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, usuario, password) 
            VALUES ('$nombre', '$email', '$usuario', '$password_hash')";

    if ($conexion->query($sql)) {
        echo json_encode(['status' => 'success', 'mensaje' => 'Registro exitoso. Redirigiendo...']);
    } else {
        if ($conexion->errno === 1062) {
            throw new Exception("El usuario o email ya están registrados");
        } else {
            throw new Exception("Error al guardar: " . $conexion->error);
        }
    }

    $conexion->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'mensaje' => $e->getMessage()]);
}