<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

require_once __DIR__ . '/../Entity/Pedido.php';

use App\Entity\Pedido;

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;

if ($usuario_id) {
    $conn = $entityManager->getConnection();

    $repoPedido = $entityManager->getRepository(Pedido::class);
    $misPedidos = $repoPedido->findBy(['usuario' => $usuario_id]);
}

?>

<div class="section-title">
    <i class="bi bi-bag-check"></i> Mis Pedidos
</div>


<div class="pedidos-container">
    <?php if (empty($misPedidos)): ?>
        <div class="empty-state">
            <i class="bi bi-bag-x"></i>
            <h3>No tienes pedidos aún</h3>
            <p>Cuando realices tu primer pedido, aparecerá aquí</p>
            <a href="/index.php" class="btn btn-primary">Ir a la tienda</a>
        </div>
    <?php else: ?>
        <?php foreach ($misPedidos as $pedido): ?>
            <div class="pedido-card" data-status="<?php echo htmlspecialchars($pedido->getNombre()); ?>">
                <div class="pedido-header">
                    <div>
                        <h5 class="pedido-id">#<?php echo $pedido->getNombre(); ?></h5>
                        <p class="pedido-date">
                            <i class="bi bi-calendar3"></i>
                            <?php echo $pedido->getFecha()->format('d/m/Y H:i'); ?>
                        </p>
                    </div>
                </div>

                <div class="pedido-body">
                    <div class="pedido-info">
                        <div class="info-item">
                            <i class="bi bi-box-seam"></i>
                            <!--Usar el getter-->
                            <span><?php echo $pedido->getCantidadProductos(); ?> productos</span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-cash"></i>
                            
                            <span>Importe: <?php echo number_format((float) $pedido->getPrecio(), 2); ?>€</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>



<script src="../src/Js/pedidos.js"></script>