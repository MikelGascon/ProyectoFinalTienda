<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;

// Query real a favoritos - Ajusta según tu estructura de BD
$favoritos = [];
if ($usuario_id) {
    try {
        $conn = $entityManager->getConnection();
        $sql = "SELECT p.* FROM productos p 
                INNER JOIN favoritos f ON p.id = f.producto_id 
                WHERE f.usuario_id = ? 
                ORDER BY f.fecha_agregado DESC";
        $favoritos = $conn->fetchAllAssociative($sql, [$usuario_id]);
    } catch (Exception $e) {
        // Datos de ejemplo si falla la query
        $favoritos = [
            [
                'id' => 1,
                'nombre' => 'Camisa Elegante',
                'precio' => 49.99,
                'imagen' => 'camisa1.jpg',
                'stock' => 15,
                'talla' => 'M'
            ],
            [
                'id' => 2,
                'nombre' => 'Pantalón Casual',
                'precio' => 59.99,
                'imagen' => 'pantalon1.jpg',
                'stock' => 8,
                'talla' => 'L'
            ],
        ];
    }
}
?>

<div class="section-title">
    <i class="bi bi-heart-fill"></i> Mis Favoritos
    <span class="count-badge"><?php echo count($favoritos); ?> productos</span>
</div>

<div class="favoritos-actions mb-4">
    <div class="btn-group">
        <button class="filter-btn active" data-view="grid">
            <i class="bi bi-grid-3x3-gap"></i> Cuadrícula
        </button>
        <button class="filter-btn" data-view="list">
            <i class="bi bi-list-ul"></i> Lista
        </button>
    </div>
    <?php if (!empty($favoritos)): ?>
        <button class="btn btn-outline-danger" onclick="limpiarFavoritos()">
            <i class="bi bi-trash"></i> Limpiar Todo
        </button>
    <?php endif; ?>
</div>

<div class="favoritos-container" data-view="grid">
    <?php if (empty($favoritos)): ?>
        <div class="empty-state">
            <i class="bi bi-heart-fill"></i>
            <h3>Tu lista de favoritos está vacía</h3>
            <p>Explora nuestra tienda y guarda los productos que te gusten</p>
            
            <a href="../public/filtro.php" class="btn btn-primary">
                Ir a la Tienda
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($favoritos as $producto): ?>
            <div class="favorito-item">
                <div class="favorito-img">
                    <img src="../assets/productos/<?php echo htmlspecialchars($producto['imagen'] ?? 'default.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <button class="btn-remove-fav" onclick="quitarFavorito(<?php echo $producto['id']; ?>)">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                    <?php if (isset($producto['stock']) && $producto['stock'] < 5): ?>
                        <span class="badge-stock">¡Últimas unidades!</span>
                    <?php endif; ?>
                </div>
                
                <div class="favorito-info">
                    <h5 class="favorito-nombre"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                    
                    <?php if (isset($producto['talla'])): ?>
                        <p class="favorito-talla">Talla: <?php echo htmlspecialchars($producto['talla']); ?></p>
                    <?php endif; ?>
                    
                    <div class="favorito-precio">
                        €<?php echo number_format($producto['precio'], 2); ?>
                    </div>
                    
                    <?php if (isset($producto['stock']) && $producto['stock'] > 0): ?>
                        <p class="favorito-stock">
                            <i class="bi bi-check-circle text-success"></i> 
                            En stock (<?php echo $producto['stock']; ?> disponibles)
                        </p>
                    <?php else: ?>
                        <p class="favorito-stock">
                            <i class="bi bi-x-circle text-danger"></i> 
                            Agotado
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="favorito-actions">
                    <button class="btn btn-primary btn-block" 
                            onclick="agregarAlCarrito(<?php echo $producto['id']; ?>)"
                            <?php echo (isset($producto['stock']) && $producto['stock'] <= 0) ? 'disabled' : ''; ?>>
                        <i class="bi bi-cart-plus"></i> Añadir al Carrito
                    </button>
                    <button class="btn btn-outline-primary btn-block" 
                            onclick="verProducto(<?php echo $producto['id']; ?>)">
                        <i class="bi bi-eye"></i> Ver Producto
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
// Cambiar vista
document.querySelectorAll('.filter-btn[data-view]').forEach(btn => {
    btn.addEventListener('click', function() {
        const view = this.getAttribute('data-view');
        
        document.querySelectorAll('.filter-btn[data-view]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        document.querySelector('.favoritos-container').setAttribute('data-view', view);
    });
});

function quitarFavorito(productoId) {
    if (confirm('¿Quitar este producto de favoritos?')) {
        // AJAX para quitar de favoritos
        fetch('../src/procesos/quitar_favorito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ producto_id: productoId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recargar la sección de favoritos
                document.querySelector('[data-section="favoritos"]').click();
                
                // Mostrar notificación
                showNotification('Producto eliminado de favoritos', 'success');
            } else {
                showNotification('Error al eliminar el producto', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error al eliminar el producto', 'error');
        });
    }
}

function limpiarFavoritos() {
    if (confirm('¿Estás seguro de que quieres eliminar todos tus favoritos?')) {
        // AJAX para limpiar todos los favoritos
        fetch('../src/procesos/limpiar_favoritos.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('[data-section="favoritos"]').click();
                showNotification('Favoritos limpiados correctamente', 'success');
            }
        });
    }
}

function agregarAlCarrito(productoId) {
    // AJAX para agregar al carrito
    fetch('../src/procesos/agregar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            producto_id: productoId,
            cantidad: 1 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Producto agregado al carrito', 'success');
            // Actualizar contador del carrito si existe
            updateCartCount();
        } else {
            showNotification(data.message || 'Error al agregar al carrito', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error al agregar al carrito', 'error');
    });
}

function verProducto(productoId) {
    window.location.href = `producto.php?id=${productoId}`;
}

function showNotification(message, type) {
    // Implementar sistema de notificaciones toast
    alert(message);
}

function updateCartCount() {
    // Actualizar el contador del carrito en el header
    console.log('Actualizando contador del carrito...');
}
</script>