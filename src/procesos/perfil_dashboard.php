<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/TarjetaRegalo.php'; 


use App\Entity\TarjetaRegalo;

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$usuario = $_SESSION['usuario'] ?? 'Invitado';
$email = $_SESSION['email'] ?? 'email@example.com';
$telefono = $_SESSION['telefono'] ?? 'No especificado';


if($usuario_id){
    $conn = $entityManager->getConnection();

    // 1. Contar favoritos y pedidos
    $totalFavoritos = $conn->fetchOne("SELECT COUNT(*) FROM favoritos WHERE usuario_id = ?", [$usuario_id]);
    $totalPedidos = $conn->fetchOne("SELECT COUNT(*) FROM pedido WHERE usuario_id = ?", [$usuario_id]);

    // 2. OBTENER TARJETAS REGALO MEDIANTE ORM
    $repoTarjetas = $entityManager->getRepository(TarjetaRegalo::class);

    
    // Buscamos todas las tarjetas que pertenezcan a este usuario
    $misTarjetas = $repoTarjetas->findBy(['usuario' => $usuario_id]);
    
    // La cantidad de tarjetas es el tamaño del array obtenido
    $tarjetaRegalo = count($misTarjetas);
}
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
    <!-- Cantidad de Tarjetas regalo para cada usuario-->
    <?php if (empty($misTarjetas)): ?>
        <div class="alert alert-info">No tienes tarjetas regalo todavía.</div>
    <?php else: ?>
        <?php foreach ($misTarjetas as $tarjeta): ?>
            <div class="order-card mb-3">
                <div class="order-header">
                    <span class="order-id">
                        <strong>#<?php echo $tarjeta->getCodigo(); ?></strong>
                    </span>
                </div>

                <div class="text-muted small">
                    <div>Fecha: <strong><?php echo $tarjeta->getFechaCompra()->format('d/m/Y'); ?></strong></div>
                    <div>Total Importe: <strong><?php echo number_format($tarjeta->getImporte(), 2); ?>€</strong></div>
                    <div>Descripción: <strong><?php echo $tarjeta->getMensaje() ?: 'Sin mensaje'; ?></strong></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>


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