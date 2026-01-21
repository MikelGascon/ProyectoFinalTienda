<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$usuario = $_SESSION['usuario'] ?? 'Invitado';
$email = $_SESSION['email'] ?? 'email@example.com';
$telefono = $_SESSION['telefono'] ?? 'No especificado';

// Contar favoritos
$totalFavoritos = 0;
if ($usuario_id) {
    $conn = $entityManager->getConnection();
    $totalFavoritos = $conn->fetchOne("SELECT COUNT(*) FROM favoritos WHERE usuario_id = ?", [$usuario_id]);
}

// Obtener total de pedido
$totalPedidos = 0;
if ($usuario_id) {
    $conn = $entityManager->getConnection();
    $totalPedidos = $conn->fetchOne("SELECT COUNT(*) FROM pedido WHERE usuario_id = ?", [$usuario_id]);
}

//Obtener total de tarjetas de regalo
$tarjetaRegalo = 0;
if ($usuario_id) {
    $conn = $entityManager->getConnection();
    $tarjetaRegalo = $conn->fetchOne("SELECT COUNT(*) FROM tarjetas_regalo WHERE usuario_id = ?", [$usuario_id]);
}

//Sacar todos los datos de la tarjeta Regalo para usarlo en el div


$nombreTarjeta = "nombre";
$descripcionTarjeta = "Descripcion";
$fechaTarjeta = "10/02/2026";
$importeTarjeta = "100$";


?>

<div class="section-title">
    <i class="bi bi-speedometer2"></i> Panel de Control
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-bag-check-fill"></i></div>
        <div class="stat-number"><?php echo $totalPedidos; ?></div>
        <div class="stat-label">Pedidos Totales</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-gift-fill"></i></div>
        <div class="stat-number"><?php echo $tarjetaRegalo; ?></div>
        <div class="stat-label">Tarjetas Regalo</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-heart-fill"></i></div>
        <div class="stat-number"><?php echo $totalFavoritos; ?></div>
        <div class="stat-label">Favoritos</div>
    </div>
</div>

<div class="section-title mt-4">
    <i class="bi bi-person-vcard"></i> Información Personal
</div>

<div class="info-card">
    <div class="info-row">
        <span class="info-label">Nombre Completo</span>
        <span class="info-value"><?php echo htmlspecialchars($nombreUsuario); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Usuario</span>
        <span class="info-value"><?php echo htmlspecialchars($usuario); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-value"><?php echo htmlspecialchars($email); ?></span>
    </div>
    <div class="info-row">
        <span class="info-label">Fecha de Registro</span>
        <span class="info-value"><?php echo date('d/m/Y'); ?></span>
    </div>
</div>

<div class="text-end mt-3">
    <button class="btn btn-edit" onclick="enableEdit()">
        <i class="bi bi-pencil-square me-2"></i>Editar Información
    </button>
</div>

<div class="recent-orders">
    <div class="section-title">
        <i class="bi bi-gift-fill"></i> Tarjetas Regalo
    </div>

    <div class="order-card">

        <div class="order-header">
            <span class="order-id"> <strong>#<?php echo $nombreTarjeta ?></strong></span>
        </div>
        <div class="text-muted small">
            <div>Fecha: <strong><?php echo $fechaTarjeta ?></strong>
                <div>
                    <div>Total Importe: <strong><?php echo $importeTarjeta ?></strong></div>
                    <div>Descripcion: <strong><?php echo $descripcionTarjeta ?></strong></div>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none view-all-link" data-section="pedidos">
                    Ver todos las Tarjeta Regalo <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <script>
            function enableEdit() {
                alert('Función de edición - Aquí puedes implementar un modal o formulario de edición');
            }

            // Event listener para el link "Ver todos los pedidos"
            document.querySelector('.view-all-link')?.addEventListener('click', function (e) {
                e.preventDefault();
                const section = this.getAttribute('data-section');
                document.querySelector(`[data-section="${section}"]`).click();
            });
        </script>