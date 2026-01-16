<?php
// 1. CARGA DE DOCTRINE (Ruta absoluta para XAMPP)
require_once 'C:/xampp/htdocs/proyectoFinal/ProyectoFinalTienda/src/BDD/bootstrap.php'; 

use App\Entity\Producto;
use App\Entity\Marcas;
use App\Entity\TipoRopa;
use App\Entity\TallaRopa;
use App\Entity\CategoriaSexo;

// 2. LÓGICA DE FILTRADO (QueryBuilder)
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
if (!empty($_GET['talla'])) $qb->andWhere('t.nombre = :talla')->setParameter('talla', $_GET['talla']);
if (!empty($_GET['color'])) $qb->andWhere('p.color = :col')->setParameter('col', $_GET['color']);
if (!empty($_GET['precio'])) $qb->andWhere('p.precio <= :pre')->setParameter('pre', (float)$_GET['precio']);

$productos = $qb->getQuery()->getResult();

// 3. DATOS PARA SELECTORES (Cargados de BDD)
$optMarcas = $entityManager->getRepository(Marcas::class)->findAll();
$optCats = $entityManager->getRepository(CategoriaSexo::class)->findAll();
$optTipos = $entityManager->getRepository(TipoRopa::class)->findAll();
$optTallas = $entityManager->getRepository(TallaRopa::class)->findAll();

// 4. MAPEO DE IMÁGENES Y COLORES
$img_marcas = [
    'Gucci'         => 'https://media.gucci.com/style/DarkGray_Center_0_0_1200x1200/1730222114/784361_XJGTE_1152_001_100_0000_Light-camiseta-de-punto-de-algodon-estampado.jpg',
    'Dior'          => 'https://assets.christiandior.com/is/image/diorprod/M0455CBAAM66B_SBG_E01?$r2x3_raw$&crop=0,0,4000,5000&wid=1334&hei=2000&scale=1&bfc=on&qlt=85',
    'Moncler'       => 'https://moncler-cdn.thron.com/api/v1/content-delivery/shares/dpx6uv/contents/K29541A1252068950742_4/image/plumifero-con-capucha-maya-nino-azul-marino-moncler-4.jpg?w=1300&q=80',
    'Versace'       => 'https://www.versace.com/dw/image/v2/BGWN_PRD/on/demandware.static/-/Sites-ver-master-catalog/default/dw3f96a6e4/original/90_1020082-1A16350_5X000_10_PrintedSilkKnitShirt-Knitwear-Versace-online-store_0_2.jpg?sw=850&q=85&strip=true',
    'Louis Vuitton' => 'https://es.louisvuitton.com/images/is/image/lv/1/PP_VP_L/louis-vuitton-cartera-lily-con-cadena--M82509_PM2_Front%20view.jpg',
    'Default'       => 'https://via.placeholder.com/500x600?text=Luxury+Item'
];

$colores_map = [
    'Blanco' => '#FFFFFF', 'Negro' => '#000000', 'Gris' => '#808080', 
    'Beige' => '#F5F5DC', 'Azul' => '#000080', 'Rojo' => '#FF0000',
    'Verde' => '#556B2F', 'Marrón' => '#8B4513'
];

$pageTitle = "Tienda - El Corte Rebelde";
include '../src/components/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="../src/CSS/style.css">
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <form method="GET">
            
            <div class="filter-group">
                <label>Marca</label>
                <select name="marca">
                    <option value="">Todas las Marcas</option>
                    <?php foreach ($optMarcas as $m): ?>
                        <option value="<?= $m->getNombre() ?>" <?= (($_GET['marca']??'') == $m->getNombre()) ? 'selected' : '' ?>>
                            <?= $m->getNombre() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Tipo de Prenda</label>
                <select name="tipo">
                    <option value="">Todos los Tipos</option>
                    <?php foreach ($optTipos as $tr): ?>
                        <option value="<?= $tr->getNombre() ?>" <?= (($_GET['tipo']??'') == $tr->getNombre()) ? 'selected' : '' ?>>
                            <?= $tr->getNombre() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

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
                <label>Talla</label>
                <select name="talla">
                    <option value="">Cualquier Talla</option>
                    <?php foreach ($optTallas as $t): ?>
                        <option value="<?= $t->getNombre() ?>" <?= (($_GET['talla']??'') == $t->getNombre()) ? 'selected' : '' ?>><?= $t->getNombre() ?></option>
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

            <button type="submit" class="btn-apply">Aplicar Filtros</button>
            <a href="filtro.php" style="display:block; text-align:center; margin-top:15px; color:#999; text-decoration:none; font-size:0.75rem;">Limpiar Filtros</a>
        </form>
    </aside>

    <main class="main-container">
        <div class="grid-productos">
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $p): ?>
                    <?php 
                        $nombreMarca = $p->getMarca() ? $p->getMarca()->getNombre() : 'Default';
                        $urlImagen = $img_marcas[$nombreMarca] ?? $img_marcas['Default'];
                    ?>
                    <div class="producto-card">
                        <div class="prod-img">
                            <img src="<?= $urlImagen ?>" alt="<?= $p->getNombre() ?>" class="img-fit">
                        </div>

                        <div class="prod-name"><?= htmlspecialchars($p->getNombre()) ?></div>
                        <div class="prod-price"><?= number_format($p->getPrecio(), 2) ?> €</div>
                        <div class="prod-info">
                            <?= $p->getMarca() ? $p->getMarca()->getNombre() : 'Original' ?> | 
                            <?= $p->getTalla() ? $p->getTalla()->getNombre() : 'U' ?>
                        </div>
                        
                        <a href="detalles.php?id=<?= $p->getId() ?>" class="btn-link btn-outline">Ver Detalles</a>
                        <a href="#" class="btn-link btn-dark">Añadir al Carrito</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #666;">
                    No se han encontrado productos con esos filtros.
                </p>
            <?php endif; ?>
        </div>
    </main>
</div>

<script>
    // Script para actualizar el texto del precio en tiempo real
    const range = document.getElementById('p-range');
    const label = document.getElementById('p-val');
    range.oninput = () => { label.innerText = range.value; };
</script>

<?php include "../src/components/footer.php" ?>
</body>
</html>