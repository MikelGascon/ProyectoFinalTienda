<?php
session_start();

if (isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
    
    
}

header("Location: carrito.php"); 
exit();
?>