<?php

require_once '../config/config.php';
require_once '../src/Entity/bootstrap.php';

require_once '../src/Entity/Producto.php';
require_once '../src/Entity/Marcas.php';
require_once '../src/Entity/TipoRopa.php';
require_once '../src/Entity/TallaRopa.php';
require_once '../src/Entity/CategoriaSexo.php';

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

if (!empty($_GET['marca']))
    $qb->andWhere('m.nombre = :m')->setParameter('m', $_GET['marca']);
if (!empty($_GET['categoria']))
    $qb->andWhere('c.nombre = :cat')->setParameter('cat', $_GET['categoria']);
if (!empty($_GET['tipo']))
    $qb->andWhere('tr.nombre = :tipo')->setParameter('tipo', $_GET['tipo']);
if (!empty($_GET['talla']))
    $qb->andWhere('t.nombre = :talla')->setParameter('talla', $_GET['talla']);
if (!empty($_GET['color']))
    $qb->andWhere('p.color = :col')->setParameter('col', $_GET['color']);
if (!empty($_GET['precio']))
    $qb->andWhere('p.precio <= :pre')->setParameter('pre', (float) $_GET['precio']);

$productos = $qb->getQuery()->getResult();

// 3. DATOS PARA SELECTORES
$optMarcas = $entityManager->getRepository(Marcas::class)->findAll();
$optCats = $entityManager->getRepository(CategoriaSexo::class)->findAll();
$optTipos = $entityManager->getRepository(TipoRopa::class)->findAll();
$optTallas = $entityManager->getRepository(TallaRopa::class)->findAll();

// 4. MAPEO DE IMÁGENES
$img_productos = [
    'Camiseta Logo Gold' => 'https://media.gucci.com/style/DarkGray_Center_0_0_1200x1200/1730222114/784361_XJGTE_1152_001_100_0000_Light-camiseta-de-punto-de-algodon-estampado.jpg',
    'Bolso Saddle Mini' => 'https://assets.christiandior.com/is/image/diorprod/M0455CBAAM66B_SBG_E01?$r2x3_raw$&crop=0,0,4000,5000&wid=1334&hei=2000&scale=1&bfc=on&qlt=85',
    'Chaqueta Maya Down' => 'https://moncler-cdn.thron.com/api/v1/content-delivery/shares/dpx6uv/contents/K29541A1252068950742_4/image/plumifero-con-capucha-maya-nino-azul-marino-moncler-4.jpg?w=1300&q=80',
    'Camisa Silk Print' => 'https://www.versace.com/dw/image/v2/BGWN_PRD/on/demandware.static/-/Sites-ver-master-catalog/default/dw3f96a6e4/original/90_1020082-1A16350_5X000_10_PrintedSilkKnitShirt-Knitwear-Versace-online-store_0_2.jpg?sw=850&q=85&strip=true',
    'Cartera Monogram' => 'https://es.louisvuitton.com/images/is/image/lv/1/PP_VP_L/louis-vuitton-cartera-lily-con-cadena--M82509_PM2_Front%20view.jpg',
    'Vestido corto' => 'https://images.thebestshops.com/product_images/original/iKRIX-gucci-short-dresses-web-detailed-viscose-dress-00000124879f00s003.jpg',
    'Chaqueta Dior ' => 'https://dripkickzz.com/wp-content/uploads/2025/10/Dior-sz44-54-fxtx07-6_3863537.webp',
    'Llavero' => 'https://es.louisvuitton.com/images/is/image/lv/1/PP_VP_L/louis-vuitton-llavero-lv-dragonne--M62706_PM2_Front%20view.jpg',
    'Camiseta Versace' => 'https://images.thebestshops.com/product_images/original/SL12044-035_02-f4d863.jpg',
    'Pantalones Dior' => 'https://cdn-images.farfetch-contents.com/20/50/49/72/20504972_50589018_600.jpg',
    'Chaqueta Moncler' => 'https://holtrenfrew.scene7.com/is/image/HoltRenfrew1/m_5000896451_01',
    'Vestido Verde' => 'https://images.vestiairecollective.com/images/resized/w=1246,q=75,f=auto,/produit/vestidos-gucci-de-algodon-verde-54802360-1_2.jpg',
    'Chaqueta moncler' => 'https://www.mytheresa.com/media/1094/1238/100/17/P01068383.jpg',
    'Sudadera Dior' => 'https://cdn1.jolicloset.com/img4/detail4b/2024/05/1324295-1/ropa-punto-christian-dior.jpg',
    'Bolso gucci' => 'https://media.gucci.com/style/DarkGray_Center_0_0_1200x1200/1697733137/764960_K9GSG_8367_001_057_0000_Light-minibolso-ophidia.jpg',
    'Collar Versace' => 'https://www.versace.com/dw/image/v2/BGWN_PRD/on/demandware.static/-/Sites-ver-master-catalog/default/dw8e7806c5/original/90_1015461-1A00621_4JNF0_22_IconCrystalNecklace-Necklaces-Versace-online-store_0_1.jpg?sw=850&q=85&strip=true',
    'Default' => 'https://via.placeholder.com/500x600?text=Luxury+Item'
];

$colores_map = [
    'Blanco' => '#FFFFFF',
    'Negro' => '#000000',
    'Gris' => '#808080',
    'Beige' => '#F5F5DC',
    'Azul' => '#000080',
    'Rojo' => '#FF0000',
    'Verde' => '#556B2F',
    'Marrón' => '#8B4513',
    'Multicolor' => 'linear-gradient(45deg, red, blue, yellow)'
];

$pageTitle = "Tienda - El Corte Rebelde";
include '../src/components/header.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="../src/CSS/filtro.css">
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
                            <option value="<?= $m->getNombre() ?>" <?= (($_GET['marca'] ?? '') == $m->getNombre()) ? 'selected' : '' ?>><?= $m->getNombre() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Tipo de Prenda</label>
                    <select name="tipo">
                        <option value="">Todos los Tipos</option>
                        <?php foreach ($optTipos as $tr): ?>
                            <option value="<?= $tr->getNombre() ?>" <?= (($_GET['tipo'] ?? '') == $tr->getNombre()) ? 'selected' : '' ?>><?= $tr->getNombre() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Colección</label>
                    <select name="categoria">
                        <option value="">Todas</option>
                        <?php foreach ($optCats as $c): ?>
                            <option value="<?= $c->getNombre() ?>" <?= (($_GET['categoria'] ?? '') == $c->getNombre()) ? 'selected' : '' ?>><?= $c->getNombre() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Talla</label>
                    <select name="talla">
                        <option value="">Cualquier Talla</option>
                        <?php foreach ($optTallas as $t): ?>
                            <option value="<?= $t->getNombre() ?>" <?= (($_GET['talla'] ?? '') == $t->getNombre()) ? 'selected' : '' ?>><?= $t->getNombre() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Color</label>
                    <div class="color-grid">
                        <?php foreach ($colores_map as $nombre => $hex): ?>
                            <label class="color-circle">
                                <input type="radio" name="color" value="<?= $nombre ?>" <?= (($_GET['color'] ?? '') == $nombre) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <span class="inner" style="background: <?= $hex ?>;" title="<?= $nombre ?>"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="filter-group">
                    <label>Precio Máximo: <span id="p-val"><?= $_GET['precio'] ?? '2000' ?></span>€</label>
                    <input type="range" name="precio" min="0" max="5000" step="50"
                        value="<?= $_GET['precio'] ?? '2000' ?>" id="p-range">
                    <div class="filter-group">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <input type="number" id="p-number" name="precio" min="0" max="5000" step="50"
                                value="<?= $_GET['precio'] ?? '2000' ?>"
                                style="width: 70px; padding: 5px; border: 1px solid #ddd; border-radius: 4px; font-family: sans-serif; font-size: 0.8rem;">
                            <span style="font-size: 0.8rem; font-weight: 600;">€</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-apply">Aplicar Filtros</button>
                <a href="filtro.php" class="btn-limpiar">Limpiar Filtros</a>
            </form>
        </aside>

        <main class="main-container">
            <div class="grid-productos">
                <?php if (count($productos) > 0): ?>
                    <?php foreach ($productos as $p): ?>
                        <?php
                        $nombreProd = $p->getNombre();
                        $urlImagen = $img_productos[$nombreProd] ?? $img_productos['Default'];
                        ?>
                        <div class="producto-card">
                            <div class="prod-img">
                                <img src="<?= $urlImagen ?>" alt="<?= $nombreProd ?>" class="img-fit">
                            </div>

                            <div class="prod-name"><?= htmlspecialchars($nombreProd) ?></div>
                            <div class="prod-price"><?= number_format($p->getPrecio(), 2) ?> €</div>
                            <div class="prod-info">
                                <?= $p->getMarca() ? $p->getMarca()->getNombre() : 'Original' ?> |
                                <?= $p->getTalla() ? $p->getTalla()->getNombre() : 'U' ?>
                            </div>

                            <div class="prod-actions">
                                <a href="detalles.php?id=<?= $p->getId() ?>" class="btn-link btn-outline">Ver Detalles</a>
                                <a href="agregar_carrito.php?id=<?= $p->getId() ?>" class="btn-link btn-dark">Añadir</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-results">No se han encontrado productos con esos filtros.</p>
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