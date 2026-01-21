<?php
session_start();

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
use App\Entity\TallaRopa;
use App\Entity\CategoriaSexo;

$id = $_GET['id'] ?? null;
$error = '';
$success = '';

if (!$id) {
    header('Location: dashboard.php?msg=Producto no encontrado&tipo=error');
    exit;
}

// Obtener el producto
$producto = $entityManager->find(Producto::class, $id);

if (!$producto) {
    header('Location: dashboard.php?msg=Producto no encontrado&tipo=error');
    exit;
}

// Obtener datos para los selectores
$marcas = $entityManager->getRepository(Marcas::class)->findAll();
$tipos = $entityManager->getRepository(TipoRopa::class)->findAll();
$categorias = $entityManager->getRepository(CategoriaSexo::class)->findAll();
$tallas = $entityManager->getRepository(TallaRopa::class)->findAll();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $producto->setNombre($_POST['nombre']);
        $producto->setPrecio($_POST['precio']);
        $producto->setColor($_POST['color']);
        
        // Marca
        if (!empty($_POST['marca_id'])) {
            $marca = $entityManager->find(Marcas::class, $_POST['marca_id']);
            $producto->setMarca($marca);
        }
        
        // Tipo de ropa
        if (!empty($_POST['tipo_id'])) {
            $tipo = $entityManager->find(TipoRopa::class, $_POST['tipo_id']);
            $producto->setTipoRopa($tipo);
        }
        
        // Categoría
        if (!empty($_POST['categoria_id'])) {
            $categoria = $entityManager->find(CategoriaSexo::class, $_POST['categoria_id']);
            $producto->setCategoria($categoria);
        }
        
        // Talla
        if (!empty($_POST['talla_id'])) {
            $talla = $entityManager->find(TallaRopa::class, $_POST['talla_id']);
            $producto->setTalla($talla);
        }
        
        $entityManager->flush();
        
        // Redirigir con timestamp para evitar caché
        header('Location: dashboard.php');
        exit;
        
    } catch (Exception $e) {
        $error = 'Error al actualizar el producto: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #f5f6fa; }
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
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .nav-link:hover { color: white; background: rgba(255,255,255,0.1); }
        .main-content { margin-left: 250px; padding: 30px; }
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
        }
        .form-control:focus, .form-select:focus {
            border-color: #1a1a2e;
            box-shadow: none;
        }
        .btn-save {
            background: #1a1a2e;
            color: white;
            border-radius: 10px;
            padding: 12px 30px;
        }
        .btn-save:hover { background: #16213e; color: white; }
        .btn-cancel {
            background: #6c757d;
            color: white;
            border-radius: 10px;
            padding: 12px 30px;
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
            <a href="dashboard.php" class="nav-link"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a href="../index.php" class="nav-link"><i class="bi bi-house"></i> Ver Tienda</a>
            <a href="logout.php" class="nav-link"><i class="bi bi-box-arrow-left"></i> Cerrar Sesión</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="dashboard.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0">Editar Producto</h4>
                <small class="text-muted">ID: #<?= $producto->getId() ?></small>
            </div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nombre del producto</label>
                        <input type="text" name="nombre" class="form-control" 
                               value="<?= htmlspecialchars($producto->getNombre()) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Precio (€)</label>
                        <input type="number" name="precio" class="form-control" step="0.01" 
                               value="<?= $producto->getPrecio() ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Marca</label>
                        <select name="marca_id" class="form-select">
                            <option value="">Sin marca</option>
                            <?php foreach ($marcas as $m): ?>
                                <option value="<?= $m->getId() ?>" 
                                    <?= ($producto->getMarca() && $producto->getMarca()->getId() == $m->getId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($m->getNombre()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tipo de Ropa</label>
                        <select name="tipo_id" class="form-select">
                            <option value="">Sin tipo</option>
                            <?php foreach ($tipos as $t): ?>
                                <option value="<?= $t->getId() ?>"
                                    <?= ($producto->getTipoRopa() && $producto->getTipoRopa()->getId() == $t->getId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t->getNombre()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Colección</label>
                        <select name="categoria_id" class="form-select">
                            <option value="">Sin categoría</option>
                            <?php foreach ($categorias as $c): ?>
                                <option value="<?= $c->getId() ?>"
                                    <?= ($producto->getCategoria() && $producto->getCategoria()->getId() == $c->getId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c->getNombre()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Talla</label>
                        <select name="talla_id" class="form-select">
                            <option value="">Sin talla</option>
                            <?php foreach ($tallas as $t): ?>
                                <option value="<?= $t->getId() ?>"
                                    <?= ($producto->getTalla() && $producto->getTalla()->getId() == $t->getId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t->getNombre()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Color</label>
                        <input type="text" name="color" class="form-control" 
                               value="<?= htmlspecialchars($producto->getColor() ?? '') ?>">
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-check-lg"></i> Guardar Cambios
                    </button>
                    <a href="dashboard.php" class="btn btn-cancel">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
