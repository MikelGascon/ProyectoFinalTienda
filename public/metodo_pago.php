<?php
session_start();
require "../config/config.php";

$usuario_logeado = isset($_SESSION['usuario_id']);

$conexion = new mysqli("localhost", "root", "root", "app_tienda");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$erroresCampos = [];
$mensaje = "";

// Saber si vienes desde tarjeta_regalo.php
$desde_tarjeta_regalo = isset($_SESSION['tarjeta_regalo']);

// -----------------------------
// CALCULAR TOTAL DEL CARRITO
// -----------------------------
$carrito = $_SESSION['carrito'] ?? [];
$totalCarrito = 0;

foreach ($carrito as $item) {
    $totalCarrito += $item['precio'] * $item['cantidad'];
}

// -----------------------------
// TARJETA REGALO COMPRADA
// -----------------------------
if (isset($_POST['importe']) && !isset($_POST['metodo']) && !isset($_POST['confirmar'])) {
    $_SESSION['tarjeta_regalo'] = [
        'importe' => (float)$_POST['importe'],
        'mensaje' => $_POST['mensaje'] ?? null
    ];
    $desde_tarjeta_regalo = true;
}

if (isset($_SESSION['tarjeta_regalo'])) {
    $totalCarrito += (float)$_SESSION['tarjeta_regalo']['importe'];
}

// -----------------------------
// CAMPOS FORMULARIO
// -----------------------------
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

$descuentoTarjeta = 0;

// -----------------------------
// APLICAR TARJETA REGALO EXISTENTE
// -----------------------------
if ($usuario_logeado && isset($_POST['aplicar_tarjeta']) && !empty($_POST['usar_tarjeta'])) {

    // ❌ NO PERMITIR usar tarjeta regalo si estás comprando una
    if ($desde_tarjeta_regalo) {
        $erroresCampos['metodo'] = "No puedes usar una tarjeta regalo para comprar otra.";
    } else {
        $idTarjeta = (int)$_POST['usar_tarjeta'];

        $stmt = $conexion->prepare("SELECT importe FROM tarjetas_regalo WHERE id = ? AND usuario_id = ?");
        $stmt->bind_param("ii", $idTarjeta, $_SESSION['usuario_id']);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($resultado) {
            $descuentoTarjeta = (float)$resultado['importe'];
            $_SESSION['tarjeta_usada'] = [
                'id' => $idTarjeta,
                'importe' => $descuentoTarjeta
            ];
        }
    }
}

if (isset($_SESSION['tarjeta_usada'])) {
    $descuentoTarjeta = $_SESSION['tarjeta_usada']['importe'];
}

$totalFinal = max(0, $totalCarrito - $descuentoTarjeta);

// -----------------------------
// PROCESAR PAGO
// -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $confirmado && $usuario_logeado) {

    if (!empty($erroresCampos)) goto mostrar_formulario;

    if ($metodo === '') $erroresCampos['metodo'] = "Selecciona un método de pago.";

    if ($metodo === 'tarjeta') {
        if ($titular === '') $erroresCampos['titular'] = "El titular es obligatorio.";
        if (!preg_match('/^[0-9]{12}$/', $numero)) $erroresCampos['numero'] = "Debe tener 12 dígitos.";
        if (!preg_match('/^[0-9]{2}$/', $mes) || $mes < 1 || $mes > 12) $erroresCampos['mes'] = "Mes inválido.";
        if (!preg_match('/^[0-9]{2}$/', $anio)) $erroresCampos['anio'] = "Año inválido.";
        if (!preg_match('/^[0-9]{3}$/', $cvv)) $erroresCampos['cvv'] = "CVV inválido.";
    }

    if ($metodo === 'paypal') {
        if (!filter_var($paypal, FILTER_VALIDATE_EMAIL)) $erroresCampos['paypal'] = "Correo inválido.";
        if ($pass_paypal === '') $erroresCampos['pass_paypal'] = "Contraseña obligatoria.";
    }

    if ($metodo === 'transferencia') {
        if ($banco === '') $erroresCampos['banco'] = "Banco obligatorio.";
        if (!preg_match('/^[A-Z0-9]{10,20}$/', $iban)) $erroresCampos['iban'] = "IBAN inválido.";
    }

    if (empty($erroresCampos)) {

        // GUARDAR TARJETA REGALO COMPRADA
        if (isset($_SESSION['tarjeta_regalo'])) {
            $importe = $_SESSION['tarjeta_regalo']['importe'];
            $mensaje_tarjeta = $_SESSION['tarjeta_regalo']['mensaje'];
            $usuario_id = $_SESSION['usuario_id'];

            $stmt = $conexion->prepare("INSERT INTO tarjetas_regalo (usuario_id, importe, mensaje) VALUES (?, ?, ?)");
            $stmt->bind_param("ids", $usuario_id, $importe, $mensaje_tarjeta);
            $stmt->execute();
            $stmt->close();

            unset($_SESSION['tarjeta_regalo']);
        }

        // ACTUALIZAR TARJETA REGALO USADA
        if (isset($_SESSION['tarjeta_usada'])) {
            $idTarjeta = $_SESSION['tarjeta_usada']['id'];
            $saldo = $_SESSION['tarjeta_usada']['importe'];

            $restante = $saldo - $totalCarrito;

            if ($restante > 0) {
                $stmt = $conexion->prepare("UPDATE tarjetas_regalo SET importe = ? WHERE id = ?");
                $stmt->bind_param("di", $restante, $idTarjeta);
                $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $conexion->prepare("DELETE FROM tarjetas_regalo WHERE id = ?");
                $stmt->bind_param("i", $idTarjeta);
                $stmt->execute();
                $stmt->close();
            }

            unset($_SESSION['tarjeta_usada']);
        }

        unset($_SESSION['carrito']);
        header("Location: index.php");
        exit;
    }
}

mostrar_formulario:

// OBTENER TARJETAS REGALO
$tarjetas = [];
if ($usuario_logeado && !$desde_tarjeta_regalo) { // 👈 SOLO SI VIENE DEL CARRITO
    $stmt = $conexion->prepare("SELECT id, importe, mensaje FROM tarjetas_regalo WHERE usuario_id = ?");
    $stmt->bind_param("i", $_SESSION['usuario_id']);
    $stmt->execute();
    $tarjetas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Método de Pago</title>
    <link rel="stylesheet" href="../src/Css/metodo_pago.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="contenedor">

    <h2>Registrar método de pago</h2>

    <div class="resumen-pago">
        <h3>Total carrito: <?= number_format($totalCarrito, 2) ?> €</h3>

        <?php if ($descuentoTarjeta > 0): ?>
            <p>Tarjeta regalo aplicada: -<?= number_format($descuentoTarjeta, 2) ?> €</p>
        <?php endif; ?>

        <h3>Total final: <?= number_format($totalFinal, 2) ?> €</h3>
    </div>

    <?php if (!empty($tarjetas)): ?>
        <form method="post">
            <label>Tarjetas regalo disponibles</label>
            <select name="usar_tarjeta">
                <option value="">No usar tarjeta regalo</option>
                <?php foreach ($tarjetas as $t): ?>
                    <option value="<?= $t['id'] ?>">
                        Tarjeta #<?= $t['id'] ?> - <?= number_format($t['importe'], 2) ?> €
                    </option>
                <?php endforeach; ?>
            </select>
            <button name="aplicar_tarjeta">Aplicar tarjeta</button>
        </form>
    <?php endif; ?>

    <form method="post">

        <label>Método de pago</label>
        <select name="metodo" onchange="this.form.submit()">
            <option value="">Selecciona uno</option>
            <option value="tarjeta" <?= $metodo === 'tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
            <option value="paypal" <?= $metodo === 'paypal' ? 'selected' : '' ?>>PayPal</option>
            <option value="transferencia" <?= $metodo === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
        </select>

        <?php if ($metodo === 'tarjeta'): ?>

            <div class="fila">
                <div class="mitad">
                    <label>Titular</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="titular" placeholder="Nombre del titular" value="<?= $titular ?>">
                    </div>
                </div>

                <div class="mitad">
                    <label>Número</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-credit-card"></i>
                        <input type="text" name="numero" maxlength="12" placeholder="1234 5678 9012" value="<?= $numero ?>">
                    </div>
                </div>
            </div>

            <div class="fila">
                <div class="input-icono campo-fecha">
                    <i class="fa-solid fa-calendar"></i>
                    <input name="mes" maxlength="2" placeholder="MM" value="<?= $mes ?>">
                </div>

                <div class="input-icono campo-fecha">
                    <i class="fa-solid fa-calendar-days"></i>
                    <input name="anio" maxlength="2" placeholder="YY" value="<?= $anio ?>">
                </div>

                <div class="input-icono campo-mini">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="cvv" maxlength="3" placeholder="•••" value="<?= $cvv ?>">
                </div>
            </div>

        <?php endif; ?>

        <?php if ($metodo === 'paypal'): ?>
            <label>Correo PayPal</label>
            <div class="input-icono">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="paypal" placeholder="correo@ejemplo.com" value="<?= $paypal ?>">
            </div>

            <label>Contraseña</label>
            <div class="input-icono">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="pass_paypal" placeholder="••••••••">
            </div>
        <?php endif; ?>

        <?php if ($metodo === 'transferencia'): ?>
            <label>Banco</label>
            <div class="input-icono">
                <i class="fa-solid fa-building-columns"></i>
                <input type="text" name="banco" placeholder="Nombre del banco" value="<?= $banco ?>">
            </div>

            <label>IBAN</label>
            <div class="input-icono">
                <i class="fa-solid fa-money-check-dollar"></i>
                <input type="text" name="iban" maxlength="20" placeholder="ES00 0000 0000 0000" value="<?= $iban ?>">
            </div>
        <?php endif; ?>

        <button name="confirmar">Confirmar pago</button>
    </form>

    <a href="carrito.php">Volver</a>

</div>

</body>
</html>