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