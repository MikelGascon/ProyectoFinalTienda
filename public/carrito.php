<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
</head>

<body>

    <div class="carrito-box">

        <div class="carrito-header">
            <h2>Carrito de Compras</h2>
            <img src="../src/img/logo-rebelde.png" alt="El Corte Rebelde">
        </div>

        <div class="carrito-body">

            <?php if (!isset($_SESSION['usuario'])): ?>

                <p>Debes iniciar sesión para ver tu carrito.</p>
                <a href="login.php">Ir al login</a>

            <?php else: ?>

                <h3>Productos en tu carrito</h3>

                <div class="lista-productos">
                    <p>No hay productos en el carrito todavía.</p>
                </div>

                <div class="resumen-carrito">
                    <h4>Resumen</h4>
                    <p>Total: 0€</p>
                </div>

                <div class="acciones-carrito">
                    <button>Seguir comprando</button>
                    <button>Proceder al pago</button>
                </div>

            <?php endif; ?>

        </div>

        <div class="carrito-footer">
            <p>El Corte Rebelde - Carrito</p>
        </div>

    </div>

</body>

</html>
