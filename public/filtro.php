<?php
// 1. CARGA DE DOCTRINE
require_once 'C:/xampp/htdocs/proyectoFinal/ProyectoFinalTienda/src/BDD/bootstrap.php'; 

use App\Entity\Producto;
use App\Entity\Marcas;
use App\Entity\TipoRopa;
use App\Entity\TallaRopa;
use App\Entity\CategoriaSexo;

// 2. LÓGICA DE FILTRADO (QueryBuilder con JOIN a Talla)
$repo = $entityManager->getRepository(Producto::class);
$qb = $repo->createQueryBuilder('p')
    ->leftJoin('p.categoria', 'c')
    ->leftJoin('p.marca', 'm')
    ->leftJoin('p.tipoRopa', 'tr')
    ->leftJoin('p.talla', 't');

// Aplicación de filtros dinámicos
if (!empty($_GET['marca'])) $qb->andWhere('m.nombre = :m')->setParameter('m', $_GET['marca']);
if (!empty($_GET['categoria'])) $qb->andWhere('c.nombre = :cat')->setParameter('cat', $_GET['categoria']);
if (!empty($_GET['tipo'])) $qb->andWhere('tr.nombre = :tipo')->setParameter('tipo', $_GET['tipo']);
if (!empty($_GET['talla'])) $qb->andWhere('t.nombre = :talla')->setParameter('talla', $_GET['talla']); // FILTRO DE TALLA
if (!empty($_GET['color'])) $qb->andWhere('p.color = :col')->setParameter('col', $_GET['color']);
if (!empty($_GET['precio'])) $qb->andWhere('p.precio <= :pre')->setParameter('pre', (float)$_GET['precio']);

$productos = $qb->getQuery()->getResult();

// 3. DATOS PARA SELECTORES
$optMarcas = $entityManager->getRepository(Marcas::class)->findAll();
$optCats = $entityManager->getRepository(CategoriaSexo::class)->findAll();
$optTipos = $entityManager->getRepository(TipoRopa::class)->findAll();
$optTallas = $entityManager->getRepository(TallaRopa::class)->findAll(); // OBTENER TALLAS DE DB

$colores_map = [
    'Blanco' => '#FFFFFF', 'Negro' => '#000000', 'Gris' => '#808080', 
    'Beige' => '#F5F5DC', 'Azul' => '#000080', 'Rojo' => '#FF0000',
    'Verde' => '#556B2F', 'Marrón' => '#8B4513'
];

include '../src/components/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/CSS/style.css">
    
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <form method="GET">
            <div class="filter-group">
                <label>Colección</label>
                <select name="categoria">
                    <option value="">Todas</option>
                    <?php foreach ($optCats as $c): ?>
                        <option value="<?= $c->getNombre() ?>" <?= (($_GET['categoria']??'') == $c->getNombre()) ? 'selected' : '' ?>><?= $c->getNombre() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Talla Disponible</label>
                <select name="talla">
                    <option value="">Cualquier Talla</option>
                    <?php foreach ($optTallas as $talla): ?>
                        <option value="<?= $talla->getNombre() ?>" <?= (($_GET['talla']??'') == $talla->getNombre()) ? 'selected' : '' ?>>
                            <?= $talla->getNombre() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Tipo de Prenda</label>
                <select name="tipo">
                    <option value="">Todas las piezas</option>
                    <?php foreach ($optTipos as $tipo): ?>
                        <option value="<?= $tipo->getNombre() ?>" <?= (($_GET['tipo']??'') == $tipo->getNombre()) ? 'selected' : '' ?>><?= $tipo->getNombre() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Marca</label>
                <select name="marca">
                    <option value="">Todas las Marcas</option>
                    <?php foreach ($optMarcas as $marca): ?>
                        <option value="<?= $marca->getNombre() ?>" <?= (($_GET['marca']??'') == $marca->getNombre()) ? 'selected' : '' ?>><?= $marca->getNombre() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Color</label>
                <div class="color-grid">
                    <?php foreach ($colores_map as $nombre => $hex): ?>
                        <label class="color-circle">
                            <input type="radio" name="color" value="<?= $nombre ?>" <?= (($_GET['color']??'') == $nombre) ? 'checked' : '' ?>>
                            <span class="inner" style="background-color: <?= $hex ?>;" title="<?= $nombre ?>"></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-group">
                <label>Precio Máximo: <span id="p-val"><?= $_GET['precio'] ?? '2000' ?></span>€</label>
                <input type="range" name="precio" min="0" max="10000" step="100" value="<?= $_GET['precio'] ?? '2000' ?>" id="p-range">
            </div>

            <button type="submit" class="btn-apply">Aplicar Selección</button>
            <a href="filtro.php" style="display:block; text-align:center; margin-top:15px; color:#bbb; text-decoration:none; font-size:0.7rem;">LIMPIAR FILTROS</a>
        </form>
    </aside>

    <main class="main-container">
        <div class="grid-productos">
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $p): ?>
                    <div class="producto-card">
                        <div class="prod-img">EL CORTE REBELDE</div>
                        <div class="prod-name"><?= htmlspecialchars($p->getNombre()) ?></div>
                        <div class="prod-price"><?= number_format($p->getPrecio(), 2) ?> €</div>
                        <div class="prod-info">
                            Talla: <?= $p->getTalla() ? $p->getTalla()->getNombre() : 'U' ?> | 
                            <?= $p->getColor() ?>
                        </div>
                        
                        <a href="detalles.php?id=<?= $p->getId() ?>" class="btn-link btn-outline">Ver Detalles</a>
                        <a href="#" class="btn-link btn-dark">Añadir al carrito</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; color: #999; margin-top: 100px;">
                    <p>No se han encontrado productos con estos criterios.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<script>
    const range = document.getElementById('p-range');
    const label = document.getElementById('p-val');
    range.oninput = () => { label.innerText = range.value; };
</script>

<?php include "../src/components/footer.php" ?>
</body>
</html>