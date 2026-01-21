<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;

// Datos de ejemplo - Aquí harías la query real
$direcciones = [
    [
        'id' => 1,
        'nombre' => 'Casa',
        'destinatario' => 'Juan Pérez',
        'telefono' => '+34 612 345 678',
        'direccion' => 'Calle Mayor, 123',
        'ciudad' => 'Madrid',
        'codigo_postal' => '28001',
        'provincia' => 'Madrid',
        'pais' => 'España',
        'predeterminada' => true
    ],
    [
        'id' => 2,
        'nombre' => 'Trabajo',
        'destinatario' => 'Juan Pérez',
        'telefono' => '+34 612 345 678',
        'direccion' => 'Avenida de la Castellana, 456',
        'ciudad' => 'Madrid',
        'codigo_postal' => '28046',
        'provincia' => 'Madrid',
        'pais' => 'España',
        'predeterminada' => false
    ],
];
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
    <?php if (empty($direcciones)): ?>
        <div class="empty-state">
            <i class="bi bi-house-x"></i>
            <h3>No tienes direcciones guardadas</h3>
            <p>Añade una dirección para hacer tus compras más rápidas</p>
            <button class="btn btn-primary" onclick="nuevaDireccion()">
                <i class="bi bi-plus-circle"></i> Añadir Dirección
            </button>
        </div>
    <?php else: ?>
        <?php foreach ($direcciones as $dir): ?>
            <div class="direccion-card <?php echo $dir['predeterminada'] ? 'predeterminada' : ''; ?>">
                <?php if ($dir['predeterminada']): ?>
                    <div class="badge-predeterminada">
                        <i class="bi bi-star-fill"></i> Predeterminada
                    </div>
                <?php endif; ?>
                
                <div class="direccion-header">
                    <h5><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($dir['nombre']); ?></h5>
                </div>
                
                <div class="direccion-body">
                    <p class="destinatario"><strong><?php echo htmlspecialchars($dir['destinatario']); ?></strong></p>
                    <p class="direccion-line"><?php echo htmlspecialchars($dir['direccion']); ?></p>
                    <p class="direccion-line">
                        <?php echo htmlspecialchars($dir['codigo_postal']); ?> - 
                        <?php echo htmlspecialchars($dir['ciudad']); ?>, 
                        <?php echo htmlspecialchars($dir['provincia']); ?>
                    </p>
                    <p class="direccion-line"><?php echo htmlspecialchars($dir['pais']); ?></p>
                    <p class="telefono"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($dir['telefono']); ?></p>
                </div>
                
                <div class="direccion-footer">
                    <button class="btn-action" onclick="editarDireccion(<?php echo $dir['id']; ?>)">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                    <?php if (!$dir['predeterminada']): ?>
                        <button class="btn-action" onclick="setPredeterminada(<?php echo $dir['id']; ?>)">
                            <i class="bi bi-star"></i> Predeterminada
                        </button>
                    <?php endif; ?>
                    <button class="btn-action text-danger" onclick="eliminarDireccion(<?php echo $dir['id']; ?>)">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal para Nueva/Editar Dirección (oculto por defecto) -->
<div id="direccionModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 id="modalTitle">Nueva Dirección</h5>
            <button class="btn-close" onclick="cerrarModal()">&times;</button>
        </div>
        <div class="modal-body">
            <form id="direccionForm">
                <div class="form-group">
                    <label>Nombre de la dirección</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Ej: Casa, Trabajo..." required>
                </div>
                <div class="form-group">
                    <label>Destinatario</label>
                    <input type="text" class="form-control" name="destinatario" required>
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" class="form-control" name="telefono" required>
                </div>
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" class="form-control" name="direccion" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Código Postal</label>
                        <input type="text" class="form-control" name="codigo_postal" required>
                    </div>
                    <div class="form-group col-md-8">
                        <label>Ciudad</label>
                        <input type="text" class="form-control" name="ciudad" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Provincia</label>
                        <input type="text" class="form-control" name="provincia" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>País</label>
                        <input type="text" class="form-control" name="pais" value="España" required>
                    </div>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="predeterminada" id="predeterminada">
                    <label class="form-check-label" for="predeterminada">
                        Establecer como dirección predeterminada
                    </label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <button class="btn btn-primary" onclick="guardarDireccion()">Guardar Dirección</button>
        </div>
    </div>
</div>

<script>
function nuevaDireccion() {
    document.getElementById('modalTitle').textContent = 'Nueva Dirección';
    document.getElementById('direccionForm').reset();
    document.getElementById('direccionModal').style.display = 'flex';
}

function editarDireccion(id) {
    document.getElementById('modalTitle').textContent = 'Editar Dirección';
    // Aquí cargarías los datos de la dirección con AJAX
    document.getElementById('direccionModal').style.display = 'flex';
    alert('Editar dirección ID: ' + id);
}

function cerrarModal() {
    document.getElementById('direccionModal').style.display = 'none';
}

function guardarDireccion() {
    const form = document.getElementById('direccionForm');
    if (form.checkValidity()) {
        // Aquí enviarías los datos con AJAX
        alert('Guardando dirección...');
        cerrarModal();
    } else {
        form.reportValidity();
    }
}

function setPredeterminada(id) {
    if (confirm('¿Establecer esta dirección como predeterminada?')) {
        // Aquí harías la petición AJAX
        alert('Dirección establecida como predeterminada: ' + id);
        location.reload(); // Temporal - usa AJAX en producción
    }
}

function eliminarDireccion(id) {
    if (confirm('¿Estás seguro de que quieres eliminar esta dirección?')) {
        // Aquí harías la petición AJAX
        alert('Eliminando dirección: ' + id);
    }
}

// Cerrar modal al hacer clic fuera
document.getElementById('direccionModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});
</script>