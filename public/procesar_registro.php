<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "root";
$db   = "app_tienda";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error de conexión al servidor']);
    exit;
}

$nombre   = $conexion->real_escape_string($_POST['nombre']);
$email    = $conexion->real_escape_string($_POST['email']);
$usuario  = $conexion->real_escape_string($_POST['usuario']);
$password = $_POST['password'];
$confirm  = $_POST['confirm_password'];

if ($password !== $confirm) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Las contraseñas no coinciden']);
} else {
    $password_encriptada = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nombre, email, usuario, password) VALUES ('$nombre', '$email', '$usuario', '$password_encriptada')";

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'mensaje' => 'Registro completado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'El usuario o email ya están en uso']);
    }
}

$conexion->close();