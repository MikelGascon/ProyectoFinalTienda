<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;

// Aquí harías la query real a tu base de datos
// Por ahora usamos datos de ejemplo
$pedidos = [
    [
        'id' => 'PEDIDO-2026-001',
        'fecha' => '15/01/2026',
        'total' => 89.99,
        'estado' => 'shipped',
        'estado_texto' => 'En Camino',
        'productos' => 3,
        'tracking' => 'ES123456789'
    ],
    [
        'id' => 'PEDIDO-2026-002',
        'fecha' => '10/01/2026',
        'total' => 149.99,
        'estado' => 'completed',
        'estado_texto' => 'Entregado',
        'productos' => 5,
        'tracking' => 'ES987654321'
    ],
    [
        'id' => 'PEDIDO-2025-045',
        'fecha' => '28/12/2025',
        'total' => 64.50,
        'estado' => 'pending',
        'estado_texto' => 'Procesando',
        'productos' => 2,
        'tracking' => null
    ],
];
?>

<div class="section-title">
    <i class="bi bi-bag-check"></i> Mis Pedidos
</div>

<div class="pedidos-filter mb-4">
    <button class="filter-btn active" data-filter="all">Todos</button>
    <button class="filter-btn" data-filter="pending">Procesando</button>
    <button class="filter-btn" data-filter="shipped">En Camino</button>
    <button class="filter-btn" data-filter="completed">Entregados</button>
</div>

<div class="pedidos-container">
    <?php if (empty($pedidos)): ?>
        <div class="empty-state">
            <i class="bi bi-bag-x"></i>
            <h3>No tienes pedidos aún</h3>
            <p>Cuando realices tu primer pedido, aparecerá aquí</p>
            <a href="../index.php" class="btn btn-primary">Ir a la tienda</a>
        </div>
    <?php else: ?>
        <?php foreach ($pedidos as $pedido): ?>
            <div class="pedido-card" data-status="<?php echo $pedido['estado']; ?>">
                <div class="pedido-header">
                    <div>
                        <h5 class="pedido-id">#<?php echo $pedido['id']; ?></h5>
                        <p class="pedido-date"><i class="bi bi-calendar3"></i> <?php echo $pedido['fecha']; ?></p>
                    </div>
                    <span class="order-status status-<?php echo $pedido['estado']; ?>">
                        <?php echo $pedido['estado_texto']; ?>
                    </span>
                </div>
                
                <div class="pedido-body">
                    <div class="pedido-info">
                        <div class="info-item">
                            <i class="bi bi-box-seam"></i>
                            <span><?php echo $pedido['productos']; ?> productos</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-cash"></i>
                            <span>€<?php echo number_format($pedido['total'], 2); ?></span>
                        </div>
                        <?php if ($pedido['tracking']): ?>
                            <div class="info-item">
                                <i class="bi bi-truck"></i>
                                <span><?php echo $pedido['tracking']; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="pedido-footer">
                    <button class="btn-secondary-action" onclick="verDetalles('<?php echo $pedido['id']; ?>')">
                        <i class="bi bi-eye"></i> Ver Detalles
                    </button>
                    <?php if ($pedido['estado'] === 'completed'): ?>
                        <button class="btn-primary-action" onclick="reordenar('<?php echo $pedido['id']; ?>')">
                            <i class="bi bi-arrow-repeat"></i> Volver a Comprar
                        </button>
                    <?php elseif ($pedido['estado'] === 'shipped'): ?>
                        <button class="btn-primary-action" onclick="rastrear('<?php echo $pedido['tracking']; ?>')">
                            <i class="bi bi-geo-alt"></i> Rastrear Pedido
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
// Filtros de pedidos
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Actualizar botón activo
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.getAttribute('data-filter');
        const pedidos = document.querySelectorAll('.pedido-card');
        
        pedidos.forEach(pedido => {
            if (filter === 'all' || pedido.getAttribute('data-status') === filter) {
                pedido.style.display = 'block';
            } else {
                pedido.style.display = 'none';
            }
        });
    });
});

function verDetalles(pedidoId) {
    alert('Ver detalles del pedido: ' + pedidoId);
    // Aquí puedes abrir un modal o navegar a una página de detalles
}

function reordenar(pedidoId) {
    if (confirm('¿Quieres volver a comprar los productos de este pedido?')) {
        alert('Agregando productos al carrito...');
        // Implementar lógica de reordenamiento
    }
}

function rastrear(tracking) {
    alert('Rastreando pedido: ' + tracking);
    // Aquí puedes abrir un modal con información de rastreo
}
</script>