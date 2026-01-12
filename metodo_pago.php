<?php
session_start();

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

        .contenedor {
            width: 420px;
            background: #fff;
            padding: 35px 40px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.18);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--marron-oscuro);
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: var(--negro);
            font-size: 1rem;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid var(--gris-medio);
            border-radius: 6px;
            background-color: #fff;
            font-size: 1rem;
            box-sizing: border-box; /* 🔥 Justificación perfecta */
        }

        input:focus, select:focus {
            border-color: var(--marron-claro);
            outline: none;
            box-shadow: 0 0 0 2px #AAA085;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--marron-claro);
            color: #ffffffc5;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #7e7661ff;
        }

        p {
            text-align: center;
            margin-top: 10px;
            color: var(--marron-oscuro);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--marron-claro);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="contenedor">
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
