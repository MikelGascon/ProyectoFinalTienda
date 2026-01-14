<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>

    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
            --negro: #000000;
            --gris-medio: #878686;
            --gris-claro: #D9D9D9;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background-image: url('../src/img/logo-rebelde.png');
            background-repeat: repeat;
            background-size: 140px;
            opacity: 0.08;
            transform: rotate(-35deg);
            z-index: -1;
        }

        .carrito-box {
            background-color: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18);
            width: 520px;
            overflow: hidden;
        }

        .carrito-header {
            background: linear-gradient(to bottom, var(--marron-claro), var(--marron-oscuro));
            padding: 25px 20px;
            text-align: center;
        }

        .carrito-header img {
            max-width: 150px;
            height: auto;
            display: block;
            margin: 0 auto 8px;
        }

        .carrito-header h2 {
            margin: 0;
            color: #fff;
            font-size: 1.6rem;
            font-weight: bold;
        }

        .carrito-body {
            padding: 35px 40px;
            background-color: var(--gris-claro);
        }

        .carrito-body h3 {
            margin-top: 0;
            color: var(--negro);
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .lista-productos {
            background-color: #fff;
            padding: 18px;
            border-radius: 8px;
            border: 1px solid var(--gris-medio);
            margin-bottom: 20px;
        }

        .lista-productos p {
            margin: 0;
            color: var(--gris-medio);
            font-size: 1rem;
        }

        .resumen-carrito {
            background-color: #fff;
            padding: 18px;
            border-radius: 8px;
            border: 1px solid var(--gris-medio);
            margin-bottom: 25px;
        }

        .resumen-carrito h4 {
            margin: 0 0 10px 0;
            font-size: 1.1rem;
            color: var(--negro);
        }

        .acciones-carrito {
            display: flex;
            gap: 12px;
        }

        .acciones-carrito button {
            flex: 1;
            padding: 12px;
            background-color: var(--marron-claro);
            color: #ffffffc5;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
        }

        .acciones-carrito button:hover {
            background-color: #7e7661ff;
        }

        .carrito-footer {
            padding: 18px;
            background-color: #f7f7f7;
            text-align: center;
            font-size: 0.9rem;
            color: var(--gris-medio);
        }
    </style>
</head>

<body>

    <div class="carrito-box">

        <div class="carrito-header">
            <img src="../src/img/logo-rebelde.png" alt="El Corte Rebelde">
            <h2>Carrito de Compras</h2>
        </div>

        <div class="carrito-body">

            <?php if (!isset($_SESSION['usuario'])): ?>

                <p style="text-align:center;">Debes iniciar sesión para ver tu carrito.</p>
                <div style="text-align:center; margin-top:15px;">
                    <a href="login.php" style="color: var(--marron-claro); font-weight:bold;">Ir al login</a>
                </div>

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
            El Corte Rebelde - Carrito
        </div>

    </div>

</body>

</html>
