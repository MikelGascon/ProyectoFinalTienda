<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';
$errores = [];

$metodo = $_POST['metodo'] ?? '';
$titular = $_POST['titular'] ?? '';
$numero = $_POST['numero'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$cvv = $_POST['cvv'] ?? '';
$paypal = $_POST['paypal'] ?? '';
$banco = $_POST['banco'] ?? '';
$iban = $_POST['iban'] ?? '';

$confirmado = isset($_POST['confirmar']); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $confirmado) {

    if ($metodo === '') {
        $errores[] = "Selecciona un método de pago.";
    }

    if ($metodo === 'tarjeta') {

        if ($titular === '') {
            $errores[] = "El titular es obligatorio.";
        }

        if (!preg_match('/^[0-9]{12}$/', $numero)) {
            $errores[] = "El número de tarjeta debe tener exactamente 12 dígitos.";
        }

        $mes_actual = date("Y-m");
        if ($fecha < $mes_actual) {
            $errores[] = "La fecha de expiración no puede ser anterior al mes actual.";
        }

        if (!preg_match('/^[0-9]{3}$/', $cvv)) {
            $errores[] = "El CVV debe tener exactamente 3 dígitos.";
        }

    } elseif ($metodo === 'paypal') {

        if (!filter_var($paypal, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Introduce un correo válido para PayPal.";
        }

    } elseif ($metodo === 'transferencia') {

        if ($banco === '') {
            $errores[] = "El nombre del banco es obligatorio.";
        }

        if (!preg_match('/^[A-Z0-9]{10,20}$/', $iban)) {
            $errores[] = "El IBAN debe contener entre 10 y 20 caracteres alfanuméricos.";
        }
    }

    if (empty($errores)) {
        $mensaje = "Método de pago registrado correctamente.";
    } else {
        $mensaje = implode("<br>", $errores);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Método de Pago</title>
</head>

<body>

    <div>
        <h2>Registrar método de pago</h2>

        <form method="post">

            <label for="metodo">Método de pago</label>
            <select name="metodo" id="metodo" onchange="this.form.submit()">
                <option value="">Selecciona uno</option>
                <option value="tarjeta" <?= $metodo === 'tarjeta' ? 'selected' : '' ?>>Tarjeta de crédito / débito</option>
                <option value="paypal" <?= $metodo === 'paypal' ? 'selected' : '' ?>>PayPal</option>
                <option value="transferencia" <?= $metodo === 'transferencia' ? 'selected' : '' ?>>Transferencia bancaria</option>
            </select>

            <?php if ($metodo === 'tarjeta'): ?>
                <label for="titular">Titular de la tarjeta</label>
                <input type="text" name="titular" value="<?= htmlspecialchars($titular) ?>">

                <label for="numero">Número de tarjeta</label>
                <input type="text" name="numero" maxlength="12" value="<?= htmlspecialchars($numero) ?>">

                <label for="fecha">Fecha de expiración</label>
                <input type="month" name="fecha" value="<?= htmlspecialchars($fecha) ?>">

                <label for="cvv">CVV</label>
                <input type="password" name="cvv" maxlength="3" value="<?= htmlspecialchars($cvv) ?>">
            <?php endif; ?>

            <?php if ($metodo === 'paypal'): ?>
                <label for="paypal">Correo de PayPal</label>
                <input type="email" name="paypal" value="<?= htmlspecialchars($paypal) ?>">
            <?php endif; ?>

            <?php if ($metodo === 'transferencia'): ?>
                <label for="banco">Nombre del banco</label>
                <input type="text" name="banco" value="<?= htmlspecialchars($banco) ?>">

                <label for="iban">IBAN</label>
                <input type="text" name="iban" maxlength="20" value="<?= htmlspecialchars($iban) ?>">
            <?php endif; ?>

            <button type="submit" name="confirmar" value="1">Confirmar pago</button>
        </form>

        <?php if ($confirmado && $mensaje): ?>
            <p><?= $mensaje ?></p>
        <?php endif; ?>

        <a href="#">Volver</a>
    </div>

</body>
</html>
