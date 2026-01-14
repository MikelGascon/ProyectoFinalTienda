<?php
header('Content-Type: application/json');

// 1. CONEXIÓN
$conexion = new mysqli("localhost", "root", "", "app_tienda");

if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Fallo de conexión']);
    exit;
}

// 2. RECOGIDA DE DATOS
$nombre   = $conexion->real_escape_string($_POST['nombre']);
$email    = $conexion->real_escape_string($_POST['email']);
$usuario  = $conexion->real_escape_string($_POST['usuario']);
$password = $_POST['password'];
$confirm  = $_POST['confirm_password'];

// 3. VALIDACIONES
if (empty($nombre) || empty($email) || empty($usuario) || empty($password)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Todos los campos son obligatorios']);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Las contraseñas no coinciden']);
    exit;
}

// 4. ENCRIPTACIÓN Y SQL
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, email, usuario, password) 
        VALUES ('$nombre', '$email', '$usuario', '$password_hash')";

if ($conexion->query($sql) === TRUE) {
    // Si todo va bien, mandamos éxito al AJAX
    echo json_encode(['status' => 'success', 'mensaje' => '¡Cuenta creada! Redirigiendo al login...']);
} else {
    // Error de duplicados (email o usuario ya registrados)
    echo json_encode(['status' => 'error', 'mensaje' => 'El usuario o email ya están registrados']);
}

$conexion->close();