<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Direcciones.php';

use App\Entity\Direccion;

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';

if ($usuario_id) {
    $repoDireccion = $entityManager->getRepository(Direccion::class);
    $misDirecciones = $repoDireccion->findBy(['usuario' => $usuario_id]);
}
?>

<div class="section-title">
    <i class="bi bi-house"></i> Mis Direcciones
</div>

<div class="direcciones-actions mb-4">
    <button class="btn btn-primary" onclick="nuevaDireccion()">
        <i class="bi bi-plus-circle"></i> Añadir Nueva Dirección
    </button>
</div>

<div class="direcciones-grid">
    <?php if (empty($misDirecciones)): ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No tienes direcciones guardadas todavía.
        </div>
    <?php else: ?>
        <?php foreach ($misDirecciones as $dir): ?>
            <div class="direccion-card <?php echo $dir->isPredeterminada() ? 'predeterminada' : ''; ?>">
                <?php if ($dir->isPredeterminada()): ?>
                    <div class="badge-predeterminada">
                        <i class="bi bi-star-fill"></i> Predeterminada
                    </div>
                <?php endif; ?>

                <div class="direccion-header">
                    <h5><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($dir->getNombre()); ?></h5>
                </div>

                <div class="direccion-body">
                    <p class="destinatario"><strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
                    <p class="direccion-line"><?php echo htmlspecialchars($dir->getDireccion()); ?></p>
                    <p class="direccion-line">
                        <?php echo htmlspecialchars($dir->getCodigoPostal()); ?> -
                        <?php echo htmlspecialchars($dir->getCiudad()); ?>,
                        <?php echo htmlspecialchars($dir->getProvincia()); ?>
                    </p>
                    <p class="direccion-line"><?php echo htmlspecialchars($dir->getPais()); ?></p>
                    <?php if ($dir->getTelefono()): ?>
                        <p class="telefono"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($dir->getTelefono()); ?></p>
                    <?php endif; ?>
                </div>

                <div class="direccion-actions">
                    <button class="btn btn-sm btn-outline-secondary" onclick="editarDireccion(<?php echo $dir->getId(); ?>)"
                        title="Editar">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                    <?php if (!$dir->isPredeterminada()): ?>
                        <button class="btn btn-sm btn-outline-secondary" onclick="setPredeterminada(<?php echo $dir->getId(); ?>)"
                            title="Establecer como predeterminada">
                            <i class="bi bi-star"></i> Predetermina
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="eliminarDireccion(<?php echo $dir->getId(); ?>)"
                            title="Eliminar">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal para Nueva/Editar Dirección -->
<div id="direccionModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 id="modalTitle">Nueva Dirección</h5>
            <button class="btn-close" onclick="cerrarModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="direccionForm">
                <input type="hidden" id="direccion-id" name="id">
                
                <div class="form-group mb-3">
                    <label class="form-label">
                        <i class="bi bi-tag"></i> Nombre de la dirección *
                    </label>
                    <input type="text" class="form-control" id="direccion-nombre" name="nombre" 
                           placeholder="Ej: Casa, Trabajo..." required>
                    <small class="text-muted">Un nombre para identificar esta dirección</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">
                        <i class="bi bi-telephone"></i> Teléfono *
                    </label>
                    <input type="tel" class="form-control" id="direccion-telefono" name="telefono" 
                           placeholder="666777888" required>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">
                        <i class="bi bi-geo-alt"></i> Dirección *
                    </label>
                    <input type="text" class="form-control" id="direccion-direccion" name="direccion" 
                           placeholder="Calle, número, piso..." required>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Código Postal *</label>
                            <input type="text" class="form-control" id="direccion-codigo_postal" name="codigo_postal" 
                                   placeholder="28001" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label class="form-label">Ciudad *</label>
                            <input type="text" class="form-control" id="direccion-ciudad" name="ciudad" 
                                   placeholder="Madrid" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Provincia *</label>
                            <input type="text" class="form-control" id="direccion-provincia" name="provincia" 
                                   placeholder="Madrid" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">País *</label>
                            <input type="text" class="form-control" id="direccion-pais" name="pais" 
                                   value="España" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="direccion-predeterminada" name="predeterminada">
                    <label class="form-check-label" for="direccion-predeterminada">
                        <i class="bi bi-star"></i> Establecer como dirección predeterminada
                    </label>
                </div>
                
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i> Los campos marcados con * son obligatorios
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="cerrarModal()">
                <i class="bi bi-x-circle"></i> Cancelar
            </button>
            <button class="btn btn-primary" onclick="guardarDireccion()">
                <i class="bi bi-check-circle"></i> Guardar Dirección
            </button>
        </div>
    </div>
</div>



<!-- Cargar script de direcciones -->
<script src="../src/Js/direcciones.js"></script>