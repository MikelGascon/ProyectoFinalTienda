// Filtros de pedidos (funcionalidad básica)
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
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

// Log para confirmar que los pedidos se cargaron
console.log('Pedidos cargados desde perfil_pedidos.php con ORM Doctrine');