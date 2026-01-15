<?php
session_start();

$mensaje = '';
$erroresCampos = [];

$metodo = $_POST['metodo'] ?? '';
$titular = $_POST['titular'] ?? '';
$numero = $_POST['numero'] ?? '';
$mes = $_POST['mes'] ?? '';
$anio = $_POST['anio'] ?? '';
$cvv = $_POST['cvv'] ?? '';
$paypal = $_POST['paypal'] ?? '';
$pass_paypal = $_POST['pass_paypal'] ?? '';
$banco = $_POST['banco'] ?? '';
$iban = $_POST['iban'] ?? '';

$confirmado = isset($_POST['confirmar']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $confirmado) {

    if ($metodo === '') {
        $erroresCampos['metodo'] = "Selecciona un método de pago.";
    }

    if ($metodo === 'tarjeta') {

        if ($titular === '') {
            $erroresCampos['titular'] = "El titular es obligatorio.";
        }

        if (!preg_match('/^[0-9]{12}$/', $numero)) {
            $erroresCampos['numero'] = "El número de tarjeta debe tener exactamente 12 dígitos.";
        }

        if ($mes === '' || !preg_match('/^[0-9]{2}$/', $mes) || (int)$mes < 1 || (int)$mes > 12) {
            $erroresCampos['mes'] = "Introduce un mes válido (01-12).";
        }

        if ($anio === '' || !preg_match('/^[0-9]{2}$/', $anio)) {
            $erroresCampos['anio'] = "Introduce un año válido (dos dígitos).";
        }

        if (empty($erroresCampos['mes']) && empty($erroresCampos['anio'])) {
            $fechaIngresada = "20$anio-$mes";
            $fechaActual = date("Y-m");

            if ($fechaIngresada < $fechaActual) {
                $erroresCampos['mes'] = "Fecha inválida.";
                $erroresCampos['anio'] = "Fecha inválida.";
            }
        }

        if (!preg_match('/^[0-9]{3}$/', $cvv)) {
            $erroresCampos['cvv'] = "El CVV debe tener exactamente 3 dígitos.";
        }
    }

    if ($metodo === 'paypal') {

        if (!filter_var($paypal, FILTER_VALIDATE_EMAIL)) {
            $erroresCampos['paypal'] = "Introduce un correo válido.";
        }

        if ($pass_paypal === '') {
            $erroresCampos['pass_paypal'] = "La contraseña es obligatoria.";
        }
    }

    if ($metodo === 'transferencia') {

        if ($banco === '') {
            $erroresCampos['banco'] = "El nombre del banco es obligatorio.";
        }

        if (!preg_match('/^[A-Z0-9]{10,20}$/', $iban)) {
            $erroresCampos['iban'] = "IBAN inválido.";
        }
    }

    if (empty($erroresCampos)) {
        $mensaje = "Método de pago registrado correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Método de Pago</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
            --negro: #000000;
            --gris-medio: #878686;
            --gris-claro: #D9D9D9;
            --rojo-error: #b00020;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Fondo elegante */
        body::before {
            content: "";
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background-image: url('../src/img/logo_rebelde.png');
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
            box-sizing: border-box;
        }

        .error-input {
            border-color: var(--rojo-error) !important;
            box-shadow: 0 0 0 2px rgba(176, 0, 32, 0.3) !important;
        }

        .error-text {
            color: var(--rojo-error);
            font-size: 0.85rem;
            margin-top: -12px;
            margin-bottom: 12px;
        }

        .fila {
            display: flex;
            gap: 12px;
        }

        .campo-mini, .campo-fecha {
            width: 33%;
        }

        .input-icono {
            position: relative;
        }

        .input-icono i {
            position: absolute;
            left: 12px;
            top: 35%;
            transform: translateY(-50%);
            color: var(--gris-medio);
            font-size: 1rem;
            pointer-events: none;
        }

        .input-icono input {
            padding-left: 40px;
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
            background-color: var(--marron-oscuro);
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

        <!-- MÉTODO -->
        <label for="metodo">Método de pago</label>
        <select name="metodo" id="metodo" onchange="this.form.submit()"
                class="<?= isset($erroresCampos['metodo']) ? 'error-input' : '' ?>">
            <option value="">Selecciona uno</option>
            <option value="tarjeta" <?= $metodo === 'tarjeta' ? 'selected' : '' ?>>Tarjeta de crédito / débito</option>
            <option value="paypal" <?= $metodo === 'paypal' ? 'selected' : '' ?>>PayPal</option>
            <option value="transferencia" <?= $metodo === 'transferencia' ? 'selected' : '' ?>>Transferencia bancaria</option>
        </select>
        <?php if (isset($erroresCampos['metodo'])): ?>
            <div class="error-text"><?= $erroresCampos['metodo'] ?></div>
        <?php endif; ?>

        <!-- TARJETA -->
        <?php if ($metodo === 'tarjeta'): ?>

            <label for="titular">Titular de la tarjeta</label>
            <div class="input-icono">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="titular"
                       value="<?= htmlspecialchars($titular) ?>"
                       class="<?= isset($erroresCampos['titular']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['titular'])): ?>
                <div class="error-text"><?= $erroresCampos['titular'] ?></div>
            <?php endif; ?>

            <label for="numero">Número de tarjeta</label>
            <div class="input-icono">
                <i class="fa-solid fa-credit-card"></i>
                <input type="text" name="numero" maxlength="12"
                       value="<?= htmlspecialchars($numero) ?>"
                       class="<?= isset($erroresCampos['numero']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['numero'])): ?>
                <div class="error-text"><?= $erroresCampos['numero'] ?></div>
            <?php endif; ?>

            <label>Fecha de expiración y CVV</label>
            <div class="fila">

                <div class="input-icono campo-fecha">
                    <i class="fa-solid fa-calendar"></i>
                    <input list="meses" name="mes" maxlength="2" placeholder="MM"
                           value="<?= htmlspecialchars($mes) ?>"
                           class="<?= isset($erroresCampos['mes']) ? 'error-input' : '' ?>">
                </div>

                <div class="input-icono campo-fecha">
                    <i class="fa-solid fa-calendar-days"></i>
                    <input list="anios" name="anio" maxlength="2" placeholder="YY"
                           value="<?= htmlspecialchars($anio) ?>"
                           class="<?= isset($erroresCampos['anio']) ? 'error-input' : '' ?>">
                </div>

                <div class="input-icono campo-mini">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="cvv" maxlength="3" placeholder="CVV"
                           value="<?= htmlspecialchars($cvv) ?>"
                           class="<?= isset($erroresCampos['cvv']) ? 'error-input' : '' ?>">
                </div>

            </div>

            <?php if (isset($erroresCampos['mes'])): ?>
                <div class="error-text"><?= $erroresCampos['mes'] ?></div>
            <?php endif; ?>

            <?php if (isset($erroresCampos['anio'])): ?>
                <div class="error-text"><?= $erroresCampos['anio'] ?></div>
            <?php endif; ?>

            <?php if (isset($erroresCampos['cvv'])): ?>
                <div class="error-text"><?= $erroresCampos['cvv'] ?></div>
            <?php endif; ?>

        <?php endif; ?>

        <!-- PAYPAL -->
        <?php if ($metodo === 'paypal'): ?>

            <label for="paypal">Correo de PayPal</label>
            <div class="input-icono">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="paypal"
                       value="<?= htmlspecialchars($paypal) ?>"
                       class="<?= isset($erroresCampos['paypal']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['paypal'])): ?>
                <div class="error-text"><?= $erroresCampos['paypal'] ?></div>
            <?php endif; ?>

            <label for="pass_paypal">Contraseña de PayPal</label>
            <div class="input-icono">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="pass_paypal"
                       class="<?= isset($erroresCampos['pass_paypal']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['pass_paypal'])): ?>
                <div class="error-text"><?= $erroresCampos['pass_paypal'] ?></div>
            <?php endif; ?>

        <?php endif; ?>

        <!-- TRANSFERENCIA -->
        <?php if ($metodo === 'transferencia'): ?>

            <label for="banco">Nombre del banco</label>
            <input type="text" name="banco"
                   value="<?= htmlspecialchars($banco) ?>"
                   class="<?= isset($erroresCampos['banco']) ? 'error-input' : '' ?>">
            <?php if (isset($erroresCampos['banco'])): ?>
                <div class="error-text"><?= $erroresCampos['banco'] ?></div>
            <?php endif; ?>

            <label for="iban">IBAN</label>
            <input type="text" name="iban" maxlength="20"
                   value="<?= htmlspecialchars($iban) ?>"
                   class="<?= isset($erroresCampos['iban']) ? 'error-input' : '' ?>">
            <?php if (isset($erroresCampos['iban'])): ?>
                <div class="error-text"><?= $erroresCampos['iban'] ?></div>
            <?php endif; ?>

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