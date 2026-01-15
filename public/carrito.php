<?php
session_start();
$showBanner = false; 
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
        }

        .carrito-box {
            max-width: 720px;
            margin: 80px auto;
            background-color: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18);
            padding: 40px;
        }

        .carrito-box h2 {
            text-align: center;
            font-size: 1.8rem;
            color: var(--marron-oscuro);
            margin-bottom: 30px;
        }

        .lista-vacia {
            text-align: center;
            font-size: 1rem;
            color: var(--gris-medio);
            padding: 20px;
            border: 1px solid var(--gris-medio);
            border-radius: 10px;
            background-color: var(--gris-claro);
        }

        .acciones {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .acciones button {
            padding: 12px 24px;
            background-color: var(--marron-claro);
            color: #ffffffc5;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .acciones button:hover {
            background-color: var(--marron-oscuro);
        }

        .login-aviso {
            text-align: center;
            font-size: 1rem;
            color: var(--gris-medio);
        }

        .login-aviso a {
            color: var(--marron-claro);
            font-weight: bold;
            text-decoration: none;
        }

        .login-aviso a:hover {
            text-decoration: underline;
        }
    </style>
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