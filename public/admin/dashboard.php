<?php

session_start();

// Evitar caché del navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Verificar si está logueado como admin
if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header('Location: ../login.php');
    exit;
}

require_once '../../config/config.php';
$entityManager = require '../../src/Entity/bootstrap.php';
require_once '../../src/Entity/Producto.php';
require_once '../../src/Entity/Marcas.php';
require_once '../../src/Entity/TipoRopa.php';
require_once '../../src/Entity/TallaRopa.php';
require_once '../../src/Entity/CategoriaSexo.php';

use App\Entity\Producto;
use App\Entity\Marcas;
use App\Entity\TipoRopa;
use App\Entity\CategoriaSexo;

// Obtener filtros
$filtroMarca = $_GET['marca'] ?? '';
$filtroTipo = $_GET['tipo'] ?? '';
$filtroCategoria = $_GET['categoria'] ?? '';

// Datos para los selectores de filtro
$entityManager->clear();
$marcas = $entityManager->getRepository(Marcas::class)->findAll();
$tipos = $entityManager->getRepository(TipoRopa::class)->findAll();
$categorias = $entityManager->getRepository(CategoriaSexo::class)->findAll();

// Obtener todos los productos primero
$todosProductos = $entityManager->getRepository(Producto::class)->findAll();

// Mostrar todos los productos si no hay filtros activos
if (empty($filtroMarca) && empty($filtroTipo) && empty($filtroCategoria)) {
    $productos = $todosProductos;
} else {
    $productos = array_filter($todosProductos, function($p) use ($filtroMarca, $filtroTipo, $filtroCategoria) {
        if (!empty($filtroMarca) && ($p->getMarca() === null || $p->getMarca()->getNombre() !== $filtroMarca)) {
            return false;
        }
        if (!empty($filtroTipo) && ($p->getTipoRopa() === null || $p->getTipoRopa()->getNombre() !== $filtroTipo)) {
            return false;
        }
        if (!empty($filtroCategoria) && ($p->getCategoria() === null || $p->getCategoria()->getNombre() !== $filtroCategoria)) {
            return false;
        }
        return true;
    });
}

// Calcular stock total (cantidad de productos)
$totalProductos = count($productos);
$stockTotal = count($todosProductos);

// Mensaje de éxito/error
$mensaje = $_GET['msg'] ?? '';
$tipoMsg = $_GET['tipo'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin | El Corte Rebelde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f5f6fa;
        }
        .sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            color: white;
            padding: 20px 0;
            position: fixed;
            width: 250px;
        }
        .sidebar .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar .logo h4 {
            margin: 0;
            font-weight: 600;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .top-bar {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .stat-card.products .icon { background: #e3f2fd; color: #1976d2; }
        .stat-card.brands .icon { background: #f3e5f5; color: #7b1fa2; }
        .stat-card.categories .icon { background: #e8f5e9; color: #388e3c; }
        
        .table-container {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .filter-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .filter-section select {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 8px 15px;
        }
        .btn-filter {
            background: #1a1a2e;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
        }
        .btn-filter:hover {
            background: #16213e;
            color: white;
        }
        .btn-clear {
            background: #6c757d;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .btn-edit {
            background: #ffc107;
            color: #000;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.85rem;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.85rem;
        }
        .badge-marca {
            background: #e3f2fd;
            color: #1976d2;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .badge-tipo {
            background: #fff3e0;
            color: #f57c00;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .badge-categoria {
            background: #f3e5f5;
            color: #7b1fa2;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h4><i class="bi bi-shop"></i> Admin Panel</h4>
            <small>El Corte Rebelde</small>
        </div>
        <nav>
            <a href="dashboard.php" class="nav-link active">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="../index.php" class="nav-link">
                <i class="bi bi-house"></i> Ver Tienda
            </a>
            <a href="logout.php" class="nav-link">
                <i class="bi bi-box-arrow-left"></i> Cerrar Sesión
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <h4 class="mb-0">Panel de Administración</h4>
                <small class="text-muted">Gestión de productos</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">Hola, <strong><?php echo htmlspecialchars($_SESSION['admin_usuario']); ?></strong></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert alert-<?php echo $tipoMsg === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($mensaje); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card products d-flex align-items-center gap-3">
                    <div class="icon"><i class="bi bi-box-seam"></i></div>
                    <div>
                        <h3 class="mb-0"><?php echo $stockTotal; ?></h3>
                        <small class="text-muted">Total Productos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card brands d-flex align-items-center gap-3">
                    <div class="icon"><i class="bi bi-tags"></i></div>
                    <div>
                        <h3 class="mb-0"><?php echo count($marcas); ?></h3>
                        <small class="text-muted">Marcas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card categories d-flex align-items-center gap-3">
                    <div class="icon"><i class="bi bi-collection"></i></div>
                    <div>
                        <h3 class="mb-0"><?php echo count($categorias); ?></h3>
                        <small class="text-muted">Categorías</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filter-section">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Marca</label>
                    <select name="marca" class="form-select">
                        <option value="">Todas las marcas</option>
                        <?php foreach ($marcas as $m): ?>
                            <option value="<?= htmlspecialchars($m->getNombre()) ?>" <?= $filtroMarca === $m->getNombre() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m->getNombre()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tipo de Ropa</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <?php foreach ($tipos as $t): ?>
                            <option value="<?= htmlspecialchars($t->getNombre()) ?>" <?= $filtroTipo === $t->getNombre() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t->getNombre()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Colección</label>
                    <select name="categoria" class="form-select">
                        <option value="">Todas las colecciones</option>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= htmlspecialchars($c->getNombre()) ?>" <?= $filtroCategoria === $c->getNombre() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c->getNombre()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-filter">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <a href="dashboard.php" class="btn btn-clear">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabla de Productos -->
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="bi bi-box-seam"></i> Productos 
                    <span class="badge bg-secondary"><?php echo $totalProductos; ?> resultados</span>
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Tipo</th>
                            <th>Colección</th>
                            <th>Color</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($productos)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron productos
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td><strong>#<?= $producto->getId() ?></strong></td>
                                    <td><?= htmlspecialchars($producto->getNombre()) ?></td>
                                    <td>
                                        <span class="badge-marca">
                                            <?= $producto->getMarca() ? htmlspecialchars($producto->getMarca()->getNombre()) : '-' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-tipo">
                                            <?= $producto->getTipoRopa() ? htmlspecialchars($producto->getTipoRopa()->getNombre()) : '-' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-categoria">
                                            <?= $producto->getCategoria() ? htmlspecialchars($producto->getCategoria()->getNombre()) : '-' ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($producto->getColor() ?? '-') ?></td>
                                    <td><strong>€<?= number_format($producto->getPrecio(), 2) ?></strong></td>
                                    <td>
                                        <a href="editar_producto.php?id=<?= $producto->getId() ?>" class="btn btn-edit btn-sm">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <button class="btn btn-delete btn-sm" onclick="confirmarEliminar(<?= $producto->getId() ?>, '<?= htmlspecialchars($producto->getNombre()) ?>')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger"></i> Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que quieres eliminar el producto <strong id="nombreProducto"></strong>?</p>
                    <p class="text-muted small">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btnConfirmarEliminar" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarEliminar(id, nombre) {
            document.getElementById('nombreProducto').textContent = nombre;
            document.getElementById('btnConfirmarEliminar').href = 'eliminar_producto.php?id=' + id;
            new bootstrap.Modal(document.getElementById('modalEliminar')).show();
        }
    </script>
</body>
</html>
