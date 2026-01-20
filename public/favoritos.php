<?php
session_start();
$showBanner = false; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Deseos - Wishlist</title>
    <link rel="stylesheet" href="../src/CSS/favoritos.css">
</head>

<body>

    <?php include('../src/components/header.php'); ?>

    <div class="wishlist-box">
        <div class="heart-icon">♥</div>
        <h2>Mis Favoritos</h2>

        <?php if (!isset($_SESSION['usuario'])): ?>
            <div class="login-aviso">
                <p>Debes iniciar sesión para ver tus productos favoritos.</p>
                <a href="login.php">Ir al login</a>
            </div>
        <?php else: ?>
            <div class="lista-vacia">
                Aún no has guardado ninguna pieza en tu lista de deseos.
            </div>

            <div class="acciones">
                <button onclick="window.location.href='filtro.php'">Explorar Colección</button>
            </div>
        <?php endif; ?>
    </div>

    <?php include('../src/components/footer.php'); ?>

</body>
</html>