<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

require_once __DIR__ . '/../Entity/TarjetaRegalo.php';

use App\Entity\TarjetaRegalo;

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;

if($usuario_id){
    $conn = $entityManager->getConnection();

    $repoTarjetaRegalo = $entityManager->getRepository(TarjetaRegalo::class);
    $misTarjetasRegalo = $repoTarjetaRegalo->findBy(['usuario' => $usuario_id]);
}

?>

<div class="section-tittle">
    <i class="bi bi-bag-check"></i> Mis Tarjetas Regalo
</div>

<div class="tarjetasRegalo-container">
    <?php if (empty($misTarjetasRegalo)): ?>
        <div class="empty-state">
        <h3>No tienes tarjetas aun</h3>
        <p>Cuando compres tarjetas regalo, apreceran aqui</p>
        <a href="../public/tarjetasRegalo.php">Ir a la pagina de Tarjetas</a>
        </div>
    <?php else: ?>
        <?php foreach($misTarjetasRegalo as $tarjeta):?>
            <div class="tarjetaRegalo-card" data-status="<?php echo htmlspecialchars($tarjeta->getMensaje())?>">
                <div class="tarjetaRegalo-header">
                    <div>
                        <h5 class="tarjetaRegalo-id"># <?php echo htmlspecialchars($tarjeta -> getCodigo());?></h5>
                        <p class="tarjetaRegalo-date">
                            <i class="bi bi-calendar3"></i>
                            <?php echo htmlspecialchars($tarjeta->getFechaCompra()->format('d/m/y H:i'));?>
                        </p>
                    </div>
                </div>

                <div class="tarjetaRegalo-body">
                    <div class="tarjetaRegalo-info">
                        <div class="info-item">
                            <i class="bi bi-box-seam"></i>
                            <span> <?php echo $tarjeta->getMensaje()?></span>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-cash"></i>
                            <span>Importe: <?php echo $tarjeta->getImporte()?></span>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>