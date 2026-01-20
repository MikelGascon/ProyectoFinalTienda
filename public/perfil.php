<?php
require_once __DIR__ . '/../config/config.php';
require_once '../src/Entity/bootstrap.php'; // Necesario para la conexión a la DB

session_start();

// 1. LÓGICA PARA CONTAR FAVORITOS REALES
$usuario_id = $_SESSION['usuario_id'] ?? null;
$totalFavoritos = 0;

if ($usuario_id) {
    $conn = $entityManager->getConnection();
    // Contamos cuántas filas hay en la tabla favoritos para este usuario
    $totalFavoritos = $conn->fetchOne("SELECT COUNT(*) FROM favoritos WHERE usuario_id = ?", [$usuario_id]);
}

// Variables que usas en el HTML
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$usuario = $_SESSION['usuario'] ?? 'Invitado';

$pageTitle = "El Corte Rebelde";
$bannerText = "20% OFF EN COLECCIÓN DE INVIERNO";
$showBanner = true;
$basePath = "../src";
include '../src/components/header.php';
?>

<link href="<?php echo $basePath; ?>/Css/perfil.css" rel="stylesheet">

<div class="profile-container">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="profile-name"><?php echo htmlspecialchars($nombreUsuario); ?></div>
                <div class="profile-email"><?php echo htmlspecialchars($_SESSION['email'] ?? 'email@example.com'); ?></div>

                <ul class="profile-nav">
                    <li><a href="perfil.php" class="active"><i class="bi bi-person-circle"></i> <span>Mi Perfil</span></a></li>
                    <li><a href="pedidos.php"><i class="bi bi-bag-check"></i> <span>Mis Pedidos</span></a></li>
                    <li><a href="direcciones.php"><i class="bi bi-house"></i> <span>Mis Direcciones</span></a></li>
                    <li><a href="favoritos.php"><i class="bi bi-heart"></i> <span>Favoritos</span></a></li>
                    <li><a href="configuracion.php"><i class="bi bi-gear"></i> <span>Configuración</span></a></li>
                    <li><a href="../src/procesos/logout.php" style="color: #dc3545;"><i class="bi bi-box-arrow-right"></i> <span>Cerrar Sesión</span></a></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="profile-content">
                <div class="section-title">
                    <i class="bi bi-speedometer2"></i> Panel de Control
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-bag-check-fill"></i></div>
                        <div class="stat-number">12</div>
                        <div class="stat-label">Pedidos Totales</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
                        <div class="stat-number">2</div>
                        <div class="stat-label">En Proceso</div>
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
                        <span class="info-value"><?php echo htmlspecialchars($_SESSION['email'] ?? 'email@example.com'); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Teléfono</span>
                        <span class="info-value"><?php echo htmlspecialchars($_SESSION['telefono'] ?? 'No especificado'); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Fecha de Registro</span>
                        <span class="info-value"><?php echo date('d/m/Y'); ?></span>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-edit">
                        <i class="bi bi-pencil-square me-2"></i>Editar Información
                    </button>
                </div>

                <div class="recent-orders">
                    <div class="section-title">
                        <i class="bi bi-clock-history"></i> Pedidos Recientes
                    </div>

                    <div class="order-card">
                        <div class="order-header">
                            <span class="order-id">#PEDIDO-2026-001</span>
                            <span class="order-status status-shipped">En Camino</span>
                        </div>
                        <div class="text-muted small">
                            <div>Fecha: 15/01/2026</div>
                            <div>Total: €89.99</div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a href="pedidos.php" class="text-decoration-none" style="color: #000;">
                            Ver todos los pedidos <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../src/components/footer.php" ?>