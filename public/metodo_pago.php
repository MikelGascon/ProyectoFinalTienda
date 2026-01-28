<?php
session_start();

require_once __DIR__ . "/../src/Entity/TarjetaRegalo.php";
require_once __DIR__ . "/../src/Entity/Pedido.php";
require_once __DIR__ . "/../src/Entity/Usuario.php";

use App\Entity\TarjetaRegalo;
use App\Entity\Pedido;
use App\Entity\Usuario;

$entityManager = require_once __DIR__ . "/../src/Entity/bootstrap.php";

$usuario_logeado = isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
$usuario_id = $usuario_logeado ? (int)$_SESSION['usuario_id'] : null;

// Función para generar código de tarjeta regalo
function generarCodigoTarjeta() {
    $letras = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
    $numeros = rand(100, 999);
    return $letras . "-" . $numeros;
}

$erroresCampos = [];
$desde_tarjeta_regalo = isset($_SESSION['tarjeta_regalo']);

// Calcular total del carrito
$carrito = $_SESSION['carrito'] ?? [];
$totalCarrito = 0;
foreach ($carrito as $item) {
    $totalCarrito += $item['precio'] * $item['cantidad'];
}

// Si viene desde compra de tarjeta regalo
if (isset($_POST['importe']) && !isset($_POST['metodo']) && !isset($_POST['confirmar'])) {
    $_SESSION['tarjeta_regalo'] = [
        'importe' => (float)$_POST['importe'],
        'mensaje' => $_POST['mensaje'] ?? null
    ];
    $desde_tarjeta_regalo = true;
}

// Añadir importe de tarjeta regalo al total si existe
if (isset($_SESSION['tarjeta_regalo'])) {
    $totalCarrito += (float)$_SESSION['tarjeta_regalo']['importe'];
}

// Capturar datos del formulario
$metodo      = $_POST['metodo']      ?? '';
$titular     = $_POST['titular']     ?? '';
$numero      = $_POST['numero']      ?? '';
$mes         = $_POST['mes']         ?? '';
$anio        = $_POST['anio']        ?? '';
$cvv         = $_POST['cvv']         ?? '';
$paypal      = $_POST['paypal']      ?? '';
$pass_paypal = $_POST['pass_paypal'] ?? '';
$banco       = $_POST['banco']       ?? '';
$iban        = $_POST['iban']        ?? '';
$confirmado  = isset($_POST['confirmar']);

$descuentoTarjeta = 0;

// Aplicar tarjeta regalo existente como descuento
if ($usuario_logeado && isset($_POST['aplicar_tarjeta']) && !empty($_POST['usar_tarjeta'])) {
    if ($desde_tarjeta_regalo) {
        $erroresCampos['metodo'] = "No puedes usar una tarjeta regalo para comprar otra.";
    } else {
        $idTarjeta = (int)$_POST['usar_tarjeta'];
        
        try {
            // Buscar tarjeta regalo usando Doctrine
            $tarjetaRepo = $entityManager->getRepository(TarjetaRegalo::class);
            $tarjeta = $tarjetaRepo->findOneBy([
                'id' => $idTarjeta,
                'usuario' => $usuario_id
            ]);
            
            if ($tarjeta) {
                $descuentoTarjeta = (float)$tarjeta->getImporte();
                $_SESSION['tarjeta_usada'] = [
                    'id'      => $idTarjeta,
                    'importe' => $descuentoTarjeta
                ];
            }
        } catch (\Exception $e) {
            $erroresCampos['metodo'] = "Error al aplicar la tarjeta regalo.";
        }
    }
}

// Mantener descuento de sesión
if (isset($_SESSION['tarjeta_usada'])) {
    $descuentoTarjeta = $_SESSION['tarjeta_usada']['importe'];
}

// Calcular total final con descuento
$totalFinal = max(0, $totalCarrito - $descuentoTarjeta);

$descargarFactura = false;
$contenidoFactura = "";

// Procesar confirmación de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $confirmado && $usuario_logeado) {
    
    // Validar método de pago
    if ($metodo === '') {
        $erroresCampos['metodo'] = "Selecciona un método de pago.";
    }

    // Validaciones por método
    if ($metodo === 'tarjeta') {
        if ($titular === '') { 
            $erroresCampos['titular'] = "El titular es obligatorio."; 
        }
        if (!preg_match('/^[0-9]{12}$/', $numero)) { 
            $erroresCampos['numero'] = "El número debe tener 12 dígitos."; 
        }
        if (!preg_match('/^[0-9]{2}$/', $mes) || $mes < 1 || $mes > 12) { 
            $erroresCampos['mes'] = "Mes inválido."; 
        }
        if (!preg_match('/^[0-9]{2}$/', $anio)) { 
            $erroresCampos['anio'] = "Año inválido."; 
        } else {
            $anioCompleto = 2000 + (int)$anio;
            $mesActual = (int)date("m");
            $anioActual = (int)date("Y");
            if ($anioCompleto < $anioActual || ($anioCompleto == $anioActual && (int)$mes < $mesActual)) {
                $erroresCampos['anio'] = "La tarjeta está caducada.";
            }
        }
        if (!preg_match('/^[0-9]{3}$/', $cvv)) { 
            $erroresCampos['cvv'] = "El CVV debe tener 3 dígitos."; 
        }
    }

    if ($metodo === 'paypal') {
        if (!filter_var($paypal, FILTER_VALIDATE_EMAIL)) { 
            $erroresCampos['paypal'] = "Correo PayPal inválido."; 
        }
        if ($pass_paypal === '') { 
            $erroresCampos['pass_paypal'] = "La contraseña es obligatoria."; 
        }
    }

    if ($metodo === 'transferencia') {
        if ($banco === '') { 
            $erroresCampos['banco'] = "El banco es obligatorio."; 
        }
        if (!preg_match('/^[A-Z0-9]{10,20}$/', $iban)) { 
            $erroresCampos['iban'] = "IBAN inválido."; 
        }
    }

    // Si no hay errores, procesar la compra
    if (empty($erroresCampos)) {
        try {
            // Obtener objeto Usuario
            $usuario = $entityManager->find(Usuario::class, $usuario_id);
            
            if (!$usuario) {
                throw new \Exception("Usuario no encontrado.");
            }

            // Generar factura
            $contenidoFactura = "RESUMEN DE COMPRA\n";
            $contenidoFactura .= "Fecha: " . date("d-m-Y H:i") . "\n";
            $contenidoFactura .= "Método de pago: " . $metodo . "\n";
            $contenidoFactura .= "--------------------------\n";
            
            // Guardar pedidos del carrito usando Doctrine
            if (!empty($carrito)) {
                foreach ($carrito as $item) {
                    $linea = $item['nombre'] . " x" . $item['cantidad'] . " - " . number_format($item['precio'] * $item['cantidad'], 2) . " €\n";
                    $contenidoFactura .= $linea;
                    
                    // Crear entidad Pedido
                    $pedido = new Pedido();
                    $pedido->setUsuario($usuario);
                    $pedido->setNombre($item['nombre']);
                    $pedido->setPrecio((string)$item['precio']);
                    $pedido->setCantidadProductos($item['cantidad']);
                    
                    $entityManager->persist($pedido);
                }
            }
            
            // Si se está comprando una tarjeta regalo, añadirla a la factura
            if (isset($_SESSION['tarjeta_regalo'])) {
                $importeTarjeta = $_SESSION['tarjeta_regalo']['importe'];
                $mensajeTarjeta = !empty($_SESSION['tarjeta_regalo']['mensaje']) 
                    ? ' - "' . $_SESSION['tarjeta_regalo']['mensaje'] . '"' 
                    : '';
                
                $contenidoFactura .= "Tarjeta Regalo de " . number_format($importeTarjeta, 2) . " €" . $mensajeTarjeta . "\n";
            }
            
            $contenidoFactura .= "--------------------------\n";
            
            // Calcular subtotal sin descuento aplicado
            $subtotalSinDescuento = $totalCarrito;
            if (isset($_SESSION['tarjeta_regalo'])) {
                // Si estamos comprando tarjeta, el subtotal ya incluye su importe
                $contenidoFactura .= "Subtotal: " . number_format($subtotalSinDescuento, 2) . " €\n";
            } else {
                // Si solo hay productos del carrito
                $contenidoFactura .= "Subtotal: " . number_format($subtotalSinDescuento, 2) . " €\n";
            }
            
            if ($descuentoTarjeta > 0) {
                $contenidoFactura .= "Descuento Tarjeta Regalo: -" . number_format($descuentoTarjeta, 2) . " €\n";
            }
            
            $contenidoFactura .= "TOTAL FINAL: " . number_format($totalFinal, 2) . " €\n";
            
            $descargarFactura = true;

            // Si se está comprando una tarjeta regalo, guardarla
            if (isset($_SESSION['tarjeta_regalo'])) {
                $importe = $_SESSION['tarjeta_regalo']['importe'];
                $mensaje_tarjeta = !empty($_SESSION['tarjeta_regalo']['mensaje'])
                    ? $_SESSION['tarjeta_regalo']['mensaje']
                    : null;

                $codigo = generarCodigoTarjeta();

                // Crear entidad TarjetaRegalo
                $tarjetaRegalo = new TarjetaRegalo();
                $tarjetaRegalo->setUsuario($usuario);
                $tarjetaRegalo->setCodigo($codigo);
                $tarjetaRegalo->setImporte($importe);
                $tarjetaRegalo->setMensaje($mensaje_tarjeta);
                
                $entityManager->persist($tarjetaRegalo);
                unset($_SESSION['tarjeta_regalo']);
            }

            // Si se usó una tarjeta regalo, actualizar o eliminar
            if (isset($_SESSION['tarjeta_usada'])) {
                $idTarjeta = $_SESSION['tarjeta_usada']['id'];
                $saldo = $_SESSION['tarjeta_usada']['importe'];
                $restante = $saldo - $totalCarrito;
                
                $tarjetaUsada = $entityManager->find(TarjetaRegalo::class, $idTarjeta);
                
                if ($tarjetaUsada) {
                    if ($restante > 0) {
                        // Actualizar saldo restante
                        $tarjetaUsada->setImporte($restante);
                        $entityManager->persist($tarjetaUsada);
                    } else {
                        // Eliminar tarjeta si se gastó completamente
                        $entityManager->remove($tarjetaUsada);
                    }
                }
                
                unset($_SESSION['tarjeta_usada']);
            }

            // Ejecutar todas las operaciones en la base de datos
            $entityManager->flush();

            // Vaciar carrito
            unset($_SESSION['carrito']);
            
        } catch (\Exception $e) {
            $erroresCampos['metodo'] = "Error al procesar el pago: " . $e->getMessage();
            $descargarFactura = false;
        }
    }
}

// Obtener tarjetas regalo disponibles del usuario
$tarjetas = [];
if ($usuario_logeado && !$desde_tarjeta_regalo) {
    try {
        $tarjetaRepo = $entityManager->getRepository(TarjetaRegalo::class);
        $tarjetasObjetos = $tarjetaRepo->findBy(['usuario' => $usuario_id]);
        
        // Convertir a array para mantener compatibilidad con el HTML
        foreach ($tarjetasObjetos as $t) {
            $tarjetas[] = [
                'id' => $t->getId(),
                'importe' => $t->getImporte(),
                'mensaje' => $t->getMensaje()
            ];
        }
    } catch (\Exception $e) {
        // Silenciar errores de consulta
    }
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

    <?php if (!$usuario_logeado): ?>
        <div class="login-aviso">
            <p>Debes iniciar sesión para realizar el pago.</p>
            <a href="login.php">Ir al login</a>
        </div>
    <?php else: ?>

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
        <br>
        <label>Método de pago</label>
        <select name="metodo" onchange="this.form.submit()" class="<?= isset($erroresCampos['metodo']) ? 'error-input' : '' ?>">
            <option value="">Selecciona uno</option>
            <option value="tarjeta"      <?= $metodo === 'tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
            <option value="paypal"       <?= $metodo === 'paypal' ? 'selected' : '' ?>>PayPal</option>
            <option value="transferencia"<?= $metodo === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
        </select>
        <?php if (isset($erroresCampos['metodo'])): ?>
            <p class="error-text"><?= $erroresCampos['metodo'] ?></p>
        <?php endif; ?>

        <?php if ($metodo === 'tarjeta'): ?>
            <div class="fila">
                <div class="mitad">
                    <label>Titular</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="titular" placeholder="Nombre del titular" value="<?= htmlspecialchars($titular) ?>" class="<?= isset($erroresCampos['titular']) ? 'error-input' : '' ?>">
                    </div>
                    <?php if (isset($erroresCampos['titular'])): ?>
                        <p class="error-text"><?= $erroresCampos['titular'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="mitad">
                    <label>Número</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-credit-card"></i>
                        <input type="text" name="numero" maxlength="12" placeholder="1234 5678 9012" value="<?= htmlspecialchars($numero) ?>" class="<?= isset($erroresCampos['numero']) ? 'error-input' : '' ?>">
                    </div>
                    <?php if (isset($erroresCampos['numero'])): ?>
                        <p class="error-text"><?= $erroresCampos['numero'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="fila">
                <div class="campo-mini">
                    <label>Mes</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-calendar"></i>
                        <input name="mes" maxlength="2" placeholder="MM" value="<?= htmlspecialchars($mes) ?>" class="<?= isset($erroresCampos['mes']) ? 'error-input' : '' ?>">
                    </div>
                </div>
                <div class="campo-mini">
                    <label>Año</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-calendar-days"></i>
                        <input name="anio" maxlength="2" placeholder="YY" value="<?= htmlspecialchars($anio) ?>" class="<?= isset($erroresCampos['anio']) ? 'error-input' : '' ?>">
                    </div>
                </div>
                <div class="campo-mini">
                    <label>CVV</label>
                    <div class="input-icono">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="cvv" maxlength="3" placeholder="•••" value="<?= htmlspecialchars($cvv) ?>" class="<?= isset($erroresCampos['cvv']) ? 'error-input' : '' ?>">
                    </div>
                </div>
            </div>
            
            <div class="fila">
                <div class="campo-mini"> <?php if (isset($erroresCampos['mes'])): ?><p class="error-text"><?= $erroresCampos['mes'] ?></p><?php endif; ?> </div>
                <div class="campo-mini"> <?php if (isset($erroresCampos['anio'])): ?><p class="error-text"><?= $erroresCampos['anio'] ?></p><?php endif; ?> </div>
                <div class="campo-mini"> <?php if (isset($erroresCampos['cvv'])): ?><p class="error-text"><?= $erroresCampos['cvv'] ?></p><?php endif; ?> </div>
            </div>
        <?php endif; ?>

        <?php if ($metodo === 'paypal'): ?>
            <label>Correo PayPal</label>
            <div class="input-icono">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="paypal" placeholder="correo@ejemplo.com" value="<?= htmlspecialchars($paypal) ?>" class="<?= isset($erroresCampos['paypal']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['paypal'])): ?>
                <p class="error-text"><?= $erroresCampos['paypal'] ?></p>
            <?php endif; ?>

            <label>Contraseña</label>
            <div class="input-icono">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="pass_paypal" placeholder="••••••••" class="<?= isset($erroresCampos['pass_paypal']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['pass_paypal'])): ?>
                <p class="error-text"><?= $erroresCampos['pass_paypal'] ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($metodo === 'transferencia'): ?>
            <label>Banco</label>
            <div class="input-icono">
                <i class="fa-solid fa-building-columns"></i>
                <input type="text" name="banco" placeholder="Nombre del banco" value="<?= htmlspecialchars($banco) ?>" class="<?= isset($erroresCampos['banco']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['banco'])): ?>
                <p class="error-text"><?= $erroresCampos['banco'] ?></p>
            <?php endif; ?>

            <label>IBAN</label>
            <div class="input-icono">
                <i class="fa-solid fa-money-check-dollar"></i>
                <input type="text" name="iban" maxlength="20" placeholder="ES00 0000 0000 0000" value="<?= htmlspecialchars($iban) ?>" class="<?= isset($erroresCampos['iban']) ? 'error-input' : '' ?>">
            </div>
            <?php if (isset($erroresCampos['iban'])): ?>
                <p class="error-text"><?= $erroresCampos['iban'] ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <button name="confirmar">Confirmar pago</button>
    </form>

    <a href="carrito.php">Volver</a>

    <?php endif; ?>
</div>

<?php if ($descargarFactura): ?>

<script>
    (function() {
        // Generar codigo de nombre del ticket
        const timestamp = Date.now();
        const randomCode = Math.random().toString(36).substring(2, 8).toUpperCase();
        const fecha = new Date();
        const año = fecha.getFullYear();
        const mes = String(fecha.getMonth() + 1).padStart(2, '0');
        const dia = String(fecha.getDate()).padStart(2, '0');
        
        // Formato: FAC-YYYYMMDD-CODIGO-TIMESTAMP
        const nombreFactura = `FAC-${año}${mes}${dia}-${randomCode}-${timestamp}.txt`;
        
        const contenido = `<?php echo addslashes($contenidoFactura); ?>`;
        const blob = new Blob([contenido], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = nombreFactura;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 1500);
    })();
</script>
<?php endif; ?>

</body>
</html>