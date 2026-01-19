<?php
session_start();

// Recogemos el ID del producto que queremos borrar
$id = $_GET['id'] ?? null;

if ($id !== null && isset($_SESSION['carrito'][$id])) {
    // Si el producto existe en la sesión, lo eliminamos
    unset($_SESSION['carrito'][$id]);
}

// Volvemos a la página del carrito
header('Location: carrito.php');
exit;