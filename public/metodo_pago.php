<?php
session_start();

$mensaje = '';
$errores = [];

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
        $errores[] = "Selecciona un método de pago.";
    }

    if ($metodo === 'tarjeta') {

        if ($titular === '') {
            $errores[] = "El titular es obligatorio.";
        }

        if (!preg_match('/^[0-9]{12}$/', $numero)) {
            $errores[] = "El número de tarjeta debe tener exactamente 12 dígitos.";
        }

        if ($mes === '' || !preg_match('/^[0-9]{2}$/', $mes) || (int)$mes < 1 || (int)$mes > 12) {
            $errores[] = "Introduce un mes válido (01-12).";
        }

        if ($anio === '' || !preg_match('/^[0-9]{2}$/', $anio)) {
            $errores[] = "Introduce un año válido (dos dígitos).";
        }

        if (empty($errores)) {
            $fechaIngresada = "20$anio-$mes";
            $fechaActual = date("Y-m");

            if ($fechaIngresada < $fechaActual) {
                $errores[] = "La fecha de expiración no puede ser anterior al mes actual.";
            }
        }

        if (!preg_match('/^[0-9]{3}$/', $cvv)) {
            $errores[] = "El CVV debe tener exactamente 3 dígitos.";
        }

    } elseif ($metodo === 'paypal') {

        if (!filter_var($paypal, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Introduce un correo válido para PayPal.";
        }

        if ($pass_paypal === '') {
            $errores[] = "Introduce la contraseña de PayPal.";
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

    <!-- Iconos Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            box-sizing: border-box;
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

        .input-icono input,
        .input-icono select {
            padding-left: 40px;
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
                <div class="input-icono">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="titular" value="<?= htmlspecialchars($titular) ?>">
                </div>

                <label for="numero">Número de tarjeta</label>
                <div class="input-icono">
                    <i class="fa-solid fa-credit-card"></i>
                    <input type="text" name="numero" maxlength="12" value="<?= htmlspecialchars($numero) ?>">
                </div>

                <label>Fecha de expiración y CVV</label>
                <div class="fila">

                    <div class="input-icono campo-fecha">
                        <i class="fa-solid fa-calendar"></i>
                        <input list="meses" name="mes" maxlength="2" placeholder="MM" value="<?= htmlspecialchars($mes) ?>">
                        <datalist id="meses">
                            <?php
                            for ($m = 1; $m <= 12; $m++) {
                                $mm = str_pad($m, 2, "0", STR_PAD_LEFT);
                                echo "<option value='$mm'></option>";
                            }
                            ?>
                        </datalist>
                    </div>

                    <div class="input-icono campo-fecha">
                        <i class="fa-solid fa-calendar-days"></i>
                        <input list="anios" name="anio" maxlength="2" placeholder="YY" value="<?= htmlspecialchars($anio) ?>">
                        <datalist id="anios">
                            <?php
                            $anioActual = (int)date("y");
                            for ($a = $anioActual; $a <= $anioActual + 15; $a++) {
                                $aa = str_pad($a, 2, "0", STR_PAD_LEFT);
                                echo "<option value='$aa'></option>";
                            }
                            ?>
                        </datalist>
                    </div>

                    <div class="input-icono campo-mini">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="cvv" maxlength="3" placeholder="CVV" value="<?= htmlspecialchars($cvv) ?>">
                    </div>

                </div>
            <?php endif; ?>

            <?php if ($metodo === 'paypal'): ?>
                <label for="paypal">Correo de PayPal</label>
                <div class="input-icono">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="paypal" value="<?= htmlspecialchars($paypal) ?>">
                </div>

                <label for="pass_paypal">Contraseña de PayPal</label>
                <div class="input-icono">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="pass_paypal">
                </div>
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