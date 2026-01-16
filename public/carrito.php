<?php
session_start();
$showBanner = false;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../src/Css/carrito.css">
</head>

<body>

    <?php include('../src/components/header.php'); ?>

    <div class="carrito-box">
        <h2>Tu carrito</h2>

        <?php if (!isset($_SESSION['usuario'])): ?>
            <div class="login-aviso">
                <p>Debes iniciar sesión para ver tu carrito.</p>
                <a href="login.php">Ir al login</a>
            </div>
        <?php else: ?>
            <div class="lista-vacia">
                No hay productos en el carrito todavía.
            </div>

            <div class="acciones">
                <button>Seguir comprando</button>
            </div>
        <?php endif; ?>
    </div>

    <?php include('../src/components/footer.php'); ?>

</body>
</html>
