<?php
use App\Entity\Usuario;
use App\Entity\TarjetaRegalo;

$entityManager = require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Usuario.php';
header('Content-Type: application/json');

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;
$codigo = $_POST['codigo'] ?? '';
$importe = $_POST['importe'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';
$fecha_compra = $_POST['fecha_compra'] ?? '';

if ($usuario_id) {
    $conn = $entityManager->getConnection();
    
}

?>