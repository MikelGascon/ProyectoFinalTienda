<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Método de Pago</title>
</head>

<body>

    <div class="contenedor">
        <h2>Registrar método de pago</h2>

        <form method="post">
            <label for="metodo">Método de pago</label>
            <select name="metodo" id="metodo" required>
                <option value="">Selecciona uno</option>
                <option value="tarjeta">Tarjeta de crédito / débito</option>
                <option value="paypal">PayPal</option>
                <option value="transferencia">Transferencia bancaria</option>
            </select>

            <label for="titular">Titular de la tarjeta</label>
            <input type="text" name="titular" id="titular" required>

            <label for="numero">Número de tarjeta</label>
            <input type="text" name="numero" id="numero" maxlength="16" required>

            <label for="fecha">Fecha de expiración</label>
            <input type="month" name="fecha" id="fecha" required>

            <label for="cvv">CVV</label>
            <input type="password" name="cvv" id="cvv" maxlength="4" required>

            <button type="submit">Guardar método de pago</button>
        </form>

        <?php if ($mensaje): ?>
            <p><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <a href="login.php">Volver</a>
    </div>

</body>
</html>
