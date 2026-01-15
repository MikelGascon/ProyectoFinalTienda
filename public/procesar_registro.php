<?php
// 1. CONFIGURACIÓN DE RESPUESTA Y ERRORES
header('Content-Type: application/json');
error_reporting(0); // Desactivamos errores visuales para no romper el JSON

// 2. CONEXIÓN A LA BASE DE DATOS
$host = "localhost";
$user = "root";
$pass = "";
$db   = "app_tienda";

$conexion = new mysqli($host, $user, $pass, $db);

// Verificar si hay error de conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error de conexión a la base de datos']);
    exit;
}

// 3. RECOGIDA Y LIMPIEZA DE DATOS (Seguridad)
$nombre   = isset($_POST['nombre']) ? $conexion->real_escape_string($_POST['nombre']) : '';
$email    = isset($_POST['email']) ? $conexion->real_escape_string($_POST['email']) : '';
$usuario  = isset($_POST['usuario']) ? $conexion->real_escape_string($_POST['usuario']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm  = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// 4. VALIDACIONES LÓGICAS
if (empty($nombre) || empty($email) || empty($usuario) || empty($password)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Por favor, rellena todos los campos']);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Las contraseñas no coinciden']);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(['status' => 'error', 'mensaje' => 'La contraseña debe tener al menos 6 caracteres']);
    exit;
}

// 5. ENCRIPTACIÓN Y GUARDADO
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Intentar insertar el nuevo usuario
$sql = "INSERT INTO usuarios (nombre, email, usuario, password) VALUES ('$nombre', '$email', '$usuario', '$password_hash')";

if ($conexion->query($sql) === TRUE) {
    // Respuesta de éxito que activará la redirección en el registro.php
    echo json_encode(['status' => 'success', 'mensaje' => '¡Registro exitoso! Redirigiendo al login...']);
} else {
    // Manejo de errores específicos (Duplicados)
    if ($conexion->errno === 1062) {
        echo json_encode(['status' => 'error', 'mensaje' => 'El nombre de usuario o el email ya están registrados']);
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'Error técnico al guardar los datos']);
    }
}

$conexion->close();
?>