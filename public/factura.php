<?php
session_start();

// Si la sesión no existe, es que no se ha procesado el pago correctamente
if (!isset($_SESSION['ultima_factura'])) {
    // Temporalmente, puedes comentar la siguiente línea para ver qué error te da
    // o imprimir un var_dump($_SESSION) para depurar.
    header("Location: index.php");
    exit;
}

$f = $_SESSION['ultima_factura'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Compra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 40px; }
        .factura-box { max-width: 700px; margin: auto; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .header { border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; text-align: center; }
        .tabla { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .tabla th { background: #f8f9fa; color: #333; padding: 12px; border-bottom: 2px solid #dee2e6; text-align: left; }
        .tabla td { padding: 12px; border-bottom: 1px solid #eee; }
        .resumen { margin-top: 30px; text-align: right; }
        .resumen p { margin: 5px 0; font-size: 1.1em; }
        .total { font-size: 1.5em; color: #28a745; font-weight: bold; }
        .metodo-detalle { background: #e9ecef; padding: 15px; border-radius: 8px; margin-top: 20px; font-size: 0.9em; }
        .no-print { margin-top: 30px; text-align: center; }
        .btn { padding: 10px 20px; border-radius: 5px; text-decoration: none; cursor: pointer; border: none; }
        .btn-print { background: #007bff; color: white; }
        .btn-home { background: #6c757d; color: white; margin-left: 10px; }
        @media print { .no-print { display: none; } body { background: white; padding: 0; } .factura-box { box-shadow: none; width: 100%; } }
    </style>
</head>
<body>

<div class="factura-box">
    <div class="header">
        <i class="fa-solid fa-circle-check" style="font-size: 50px; color: #28a745;"></i>
        <h1>¡Gracias por tu compra!</h1>
        <p>Fecha de transacción: <?= $f['fecha'] ?></p>
    </div>

    <h3>Detalle del Pedido</h3>
    <table class="tabla">
        <thead>
            <tr>
                <th>Producto / Concepto</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($f['productos'])): ?>
                <?php foreach ($f['productos'] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre'] ?? 'Producto') ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td><?= number_format($item['precio'], 2) ?> €</td>
                    <td><?= number_format($item['precio'] * $item['cantidad'], 2) ?> €</td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($f['regalo_comprado']): ?>
                <tr>
                    <td>Tarjeta Regalo (Compra)</td>
                    <td>1</td>
                    <td><?= number_format($f['regalo_comprado']['importe'], 2) ?> €</td>
                    <td><?= number_format($f['regalo_comprado']['importe'], 2) ?> €</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="resumen">
        <p>Subtotal: <?= number_format($f['totalCarrito'], 2) ?> €</p>
        <?php if ($f['descuento'] > 0): ?>
            <p style="color: #dc3545;">Descuento Tarjeta Regalo: -<?= number_format($f['descuento'], 2) ?> €</p>
        <?php endif; ?>
        <p class="total">Total Pagado: <?= number_format($f['totalFinal'], 2) ?> €</p>
    </div>

    <div class="metodo-detalle">
        <strong>Método de pago utilizado:</strong> <?= ucfirst($f['metodo']) ?>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print"><i class="fa-solid fa-print"></i> Imprimir</button>
        <a href="index.php" class="btn btn-home">Ir al Inicio</a>
    </div>
</div>

</body>
</html>